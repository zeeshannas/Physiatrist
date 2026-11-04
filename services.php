<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'Physiatry Services in ' . cfg('city') . ' | Pain, Stroke, Sports & Nerve Care',
  'desc'  => 'Back pain, neck pain, stroke rehabilitation, sports injury, knee arthritis, nerve pain (EMG/NCV) and pediatric rehab services by ' . cfg('doctor') . ' in ' . cfg('city') . '.',
  'path'  => 'services',
  'schema'=> [breadcrumb_schema(['Home'=>'','Services'=>'services'])],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / Services</nav><h1>Our Services</h1><p>Complete physical medicine &amp; rehabilitation care</p></div></section>
<section class="sec"><div class="wrap"><div class="grid cards">
<?php foreach ($SERVICES as $slug => $s): ?>
  <a class="card tilt reveal" href="<?= e(url('services/'.$slug)) ?>"><span class="card-ico"><?= icon($s['icon'],30) ?></span><h3><?= e($s['title']) ?></h3><p><?= e($s['short']) ?></p><span class="more">Learn more <?= icon('arrow',16) ?></span></a>
<?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
