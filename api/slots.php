<?php
require_once __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json; charset=utf-8');
$date = $_GET['date'] ?? '';
$d = DateTime::createFromFormat('Y-m-d', $date);
if (!$d || $d->format('Y-m-d') !== $date) { echo json_encode(['slots'=>[]]); exit; }
if (in_array((int)$d->format('w'), cfg('closed_days'), true) || $date < date('Y-m-d')) {
    echo json_encode(['slots'=>[], 'closed'=>true]); exit;
}
$out = [];
$now = date('H:i');
foreach (cfg('slots') as $t) {
    if ($date === date('Y-m-d') && $t <= $now) continue;
    $out[] = ['time'=>$t, 'label'=>fmt_time($t), 'free'=>!slot_taken($date, $t)];
}
echo json_encode(['slots'=>$out]);
