<?php
require_once __DIR__ . '/../includes/functions.php';
header('X-Robots-Tag: noindex, nofollow');

if (isset($_GET['logout'])) { unset($_SESSION['admin']); header('Location: ./'); exit; }
$err = '';
if (($_POST['login'] ?? null) !== null) {
    if (csrf_check($_POST['csrf'] ?? null) && hash_equals(cfg('admin_password'), (string)($_POST['pw'] ?? ''))) {
        session_regenerate_id(true); $_SESSION['admin'] = true; header('Location: ./'); exit;
    }
    $err = 'Wrong password';
}
if (empty($_SESSION['admin'])): ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin login</title>
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>"></head>
<body class="adm-body"><form method="post" class="form adm-login"><h2>Admin Login</h2>
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Password<input type="password" name="pw" autofocus required></label>
<?php if ($err): ?><p class="form-msg err"><?= e($err) ?></p><?php endif; ?>
<button class="btn" name="login" value="1">Login</button></form></body></html>
<?php exit; endif;

// Status actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_check($_POST['csrf'] ?? null)) {
    $rows = appointments_all();
    foreach ($rows as $k => $r) {
        if ($r['id'] === ($_POST['id'] ?? '')) {
            if (($_POST['act'] ?? '') === 'delete') unset($rows[$k]);
            elseif (in_array($_POST['act'] ?? '', ['confirmed','completed','cancelled'], true)) $rows[$k]['status'] = $_POST['act'];
        }
    }
    appointments_save($rows); header('Location: ./'); exit;
}
$rows = appointments_all();
usort($rows, fn($a, $b) => strcmp($a['date'].$a['time'], $b['date'].$b['time']));
$today = date('Y-m-d');
$cnt = ['today'=>0,'upcoming'=>0,'total'=>count($rows)];
foreach ($rows as $r) { if ($r['status']==='cancelled') continue; if ($r['date']===$today) $cnt['today']++; if ($r['date']>=$today) $cnt['upcoming']++; }
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Appointments - Admin</title>
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>"></head>
<body class="adm-body"><div class="wrap adm">
<div class="adm-top"><h1>Appointments</h1><span><a href="<?= e(url()) ?>">View site</a> &middot; <a href="?logout=1">Logout</a></span></div>
<div class="adm-stats"><div><b><?= $cnt['today'] ?></b>Today</div><div><b><?= $cnt['upcoming'] ?></b>Upcoming</div><div><b><?= $cnt['total'] ?></b>Total</div></div>
<div class="tbl-wrap"><table class="tbl"><thead><tr><th>ID</th><th>Date / Time</th><th>Patient</th><th>Service</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($rows as $r): $msg = "Hello {$r['name']}, this is ".cfg('clinic_name').". Your appointment is on ".date('j M', strtotime($r['date']))." at ".fmt_time($r['time'])." (ID {$r['id']})."; ?>
<tr class="st-<?= e($r['status']) ?>"><td><?= e($r['id']) ?></td><td><?= e(date('D j M Y', strtotime($r['date']))) ?><br><b><?= e(fmt_time($r['time'])) ?></b></td>
<td><b><?= e($r['name']) ?></b><br><a href="tel:<?= e($r['phone']) ?>"><?= e($r['phone']) ?></a><?= $r['email'] ? '<br>'.e($r['email']) : '' ?><?= $r['message'] ? '<br><small>'.e($r['message']).'</small>' : '' ?></td>
<td><?= e($r['service']) ?></td><td><span class="badge"><?= e($r['status']) ?></span></td>
<td><a class="mini" target="_blank" rel="noopener" href="https://wa.me/<?= e(wa_phone($r['phone'])) ?>?text=<?= rawurlencode($msg) ?>">WhatsApp</a>
<form method="post" class="inl"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= e($r['id']) ?>">
<button class="mini" name="act" value="completed">Done</button><button class="mini" name="act" value="cancelled">Cancel</button>
<button class="mini del" name="act" value="delete" onclick="return confirm('Delete permanently?')">Delete</button></form></td></tr>
<?php endforeach; if (!$rows): ?><tr><td colspan="6">No appointments yet.</td></tr><?php endif; ?>
</tbody></table></div></div></body></html>
