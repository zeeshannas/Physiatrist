<?php
require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json; charset=utf-8');

function fail(string $m, int $c = 422): void { http_response_code($c); echo json_encode(['ok'=>false,'error'=>$m]); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail('Invalid request', 405);
if (!csrf_check($_POST['csrf'] ?? null)) fail('Session expired. Please refresh the page.', 403);
if (!empty($_POST['website'])) { echo json_encode(['ok'=>true]); exit; } // honeypot (bots)

// Simple rate limit: 5 bookings / hour / session
$_SESSION['bk'] = array_filter($_SESSION['bk'] ?? [], fn($t) => $t > time() - 3600);
if (count($_SESSION['bk']) >= 5) fail('Too many requests. Please call the clinic.', 429);

$name  = trim(strip_tags($_POST['name'] ?? ''));
$phone = preg_replace('/[^0-9+]/', '', $_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$svc   = trim(strip_tags($_POST['service'] ?? 'General consultation'));
$date  = $_POST['date'] ?? '';
$time  = $_POST['time'] ?? '';
$msg   = trim(strip_tags($_POST['message'] ?? ''));

if (mb_strlen($name) < 2) fail('Please enter your name.');
if (strlen($phone) < 10 || strlen($phone) > 15) fail('Please enter a valid phone number.');
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) fail('Please enter a valid email.');
$d = DateTime::createFromFormat('Y-m-d', $date);
if (!$d || $d->format('Y-m-d') !== $date || $date < date('Y-m-d')) fail('Please choose a valid date.');
if (in_array((int)$d->format('w'), cfg('closed_days'), true)) fail('Clinic is closed on that day.');
if (!in_array($time, cfg('slots'), true)) fail('Please choose a valid time slot.');

$fp = fopen(store_path(), 'c+'); // lock so two people cannot take the same slot
flock($fp, LOCK_EX);
$rows = json_decode(stream_get_contents($fp) ?: '[]', true) ?: [];
foreach ($rows as $r) {
    if ($r['date'] === $date && $r['time'] === $time && $r['status'] !== 'cancelled') {
        flock($fp, LOCK_UN); fclose($fp); fail('Sorry, this slot was just booked. Please pick another.', 409);
    }
}
$id = 'APT-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
$rows[] = [
  'id'=>$id,'name'=>$name,'phone'=>$phone,'email'=>$email,'service'=>$svc,'date'=>$date,'time'=>$time,
  'message'=>$msg,'status'=>'confirmed','reminded'=>false,'created'=>date('c'),
];
ftruncate($fp, 0); rewind($fp);
fwrite($fp, json_encode($rows, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
fflush($fp); flock($fp, LOCK_UN); fclose($fp);
$_SESSION['bk'][] = time();

$when = date('l, j F Y', strtotime($date)) . ' at ' . fmt_time($time);

// ---- Automation 1: confirmation email to the patient (only if they gave an email; silently skipped if mail is not configured)
$hdr = "From: " . cfg('clinic_name') . " <noreply@" . preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? 'localhost') . ">\r\nContent-Type: text/plain; charset=UTF-8";
if ($email) {
    @mail($email, "Appointment confirmed - $id",
      "Dear $name,\n\nYour appointment with " . cfg('doctor') . " is confirmed.\n\nWhen: $when\nWhere: " . cfg('clinic_name') . ", " . cfg('address') . "\nBooking ID: $id\n\nPlease arrive 10 minutes early and bring previous reports.\nTo reschedule call " . cfg('phone') . ".\n\nRegards,\n" . cfg('clinic_name'), $hdr);
}

// ---- Automation 2: ready WhatsApp confirmation text for the patient
$wa = wa_link("Hello, I booked an appointment.\nID: $id\nName: $name\nWhen: $when\nService: $svc");

echo json_encode(['ok'=>true,'id'=>$id,'when'=>$when,'wa'=>$wa]);
