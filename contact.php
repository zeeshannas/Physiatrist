<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'Contact & Location | ' . cfg('doctor') . ', ' . cfg('city'),
  'desc'  => 'Clinic address, phone, WhatsApp, timings and map for ' . cfg('doctor') . ' in ' . cfg('city') . '.',
  'path'  => 'contact',
  'schema'=> [breadcrumb_schema(['Home'=>'','Contact'=>'contact'])],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / Contact</nav><h1>Contact &amp; Location</h1></div></section>
<section class="sec"><div class="wrap two">
  <div class="prose">
    <h2><?= e(cfg('clinic_name')) ?></h2>
    <p><?= icon('pin',18) ?> <?= e(cfg('address')) ?></p>
    <p><?= icon('phone',18) ?> <a href="tel:<?= e(preg_replace('/\s+/','',cfg('phone'))) ?>"><?= e(cfg('phone')) ?></a></p>
    <p><?= icon('mail',18) ?> <a href="mailto:<?= e(cfg('email')) ?>"><?= e(cfg('email')) ?></a></p>
    <h3>Clinic timings</h3>
    <?php foreach (cfg('timings') as $d => $t): ?><p><?= icon('clock',18) ?> <b><?= e($d) ?>:</b> <?= e($t) ?></p><?php endforeach; ?>
    <a class="btn" href="<?= e(url('book')) ?>">Book Appointment</a>
    <a class="btn btn-outline" href="<?= e(wa_link('Hello Doctor')) ?>" target="_blank" rel="noopener">WhatsApp</a>
  </div>
  <div class="map tilt"><iframe title="Clinic location map" src="<?= e(cfg('map_embed')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
