<?php
/**
 * Automatic reminders. Run daily (e.g. 6 PM) by Windows Task Scheduler / cPanel cron:
 *   php /path/to/cron/reminders.php
 * Tomorrow ki appointments ko email bhejta hai aur clinic ke liye WhatsApp links ki list banata hai.
 */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('CLI only'); }
require_once __DIR__ . '/../includes/functions.php';

$tomorrow = date('Y-m-d', strtotime('+1 day'));
$rows = appointments_all();
$links = [];
foreach ($rows as &$r) {
    if ($r['date'] !== $tomorrow || $r['status'] !== 'confirmed' || !empty($r['reminded'])) continue;
    $when = date('l, j F', strtotime($r['date'])) . ' at ' . fmt_time($r['time']);
    $text = "Reminder: Dear {$r['name']}, your appointment with " . cfg('doctor') . " is tomorrow, $when. Booking ID {$r['id']}.";
    if (!empty($r['email'])) {
        @mail($r['email'], 'Appointment reminder - ' . $r['id'], $text . "\n\n" . cfg('clinic_name') . "\n" . cfg('address') . "\n" . cfg('phone'),
              'From: ' . cfg('clinic_name') . ' <' . cfg('email') . '>');
    }
    $links[] = $r['name'] . ': https://wa.me/' . wa_phone($r['phone']) . '?text=' . rawurlencode($text);
    $r['reminded'] = true;
}
unset($r);
appointments_save($rows);
if ($links) {
    @mail(cfg('email'), 'Tomorrow\'s WhatsApp reminders (' . count($links) . ')', implode("\n\n", $links), 'From: ' . cfg('email'));
    echo implode(PHP_EOL, $links) . PHP_EOL;
}
echo 'Done. Reminders processed: ' . count($links) . PHP_EOL;
