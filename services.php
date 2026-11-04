<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'Physiotherapy Services in ' . cfg('city') . ' | Pain, Stroke, Sports, Dry Needling & More',
  'desc'  => 'Back pain, neck pain, stroke rehab, sports injury, knee care, nerve pain, pediatric physiotherapy, dry needling, K-taping, hijama and fitness training by ' . cfg('doctor') . ' in ' . cfg('city') . '.',
  'path'  => 'services',
  'schema'=> [breadcrumb_schema(['Home'=>'','Services'=>'services'])],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / Services</nav><h1>Our Services</h1><p>Complete physiotherapy &amp; rehabilitation care</p></div></section>
<section class="sec"><div class="wrap"><div class="grid cards">
<?php foreach ($SERVICES as $slug => $s): ?>
  <?= service_card($slug, $s) ?>
<?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
