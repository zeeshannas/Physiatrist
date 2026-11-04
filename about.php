<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'About ' . cfg('doctor') . ' | Clinical Physiotherapist (DPT) in ' . cfg('city'),
  'desc'  => 'Meet ' . cfg('doctor') . ', Doctor of Physiotherapy (DPT) at ' . cfg('clinic_name') . ', ' . cfg('city') . '. Certified in dry needling, K-taping, fitness training and hijama therapy.',
  'path'  => 'about',
  'schema'=> [breadcrumb_schema(['Home'=>'','About'=>'about']), [
     '@context'=>'https://schema.org','@type'=>'Person','name'=>cfg('doctor'),'jobTitle'=>'Clinical Physiotherapist',
     'worksFor'=>['@type'=>'MedicalBusiness','name'=>cfg('clinic_name')],'url'=>abs_url('about')]],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / About</nav><h1><?= e(cfg('doctor')) ?></h1><p><?= e(cfg('title_short')) ?></p></div></section>
<section class="sec"><div class="wrap two">
  <div class="about-img"><img src="<?= e(photo("doctor", "doctor.svg")) ?>" alt="<?= e(cfg('doctor')) ?>, clinical physiotherapist in <?= e(cfg('city')) ?>" width="420" height="480" loading="lazy"></div>
  <div class="prose">
    <h2>Careful, Hands-On Physiotherapy in <?= e(cfg('city')) ?></h2>
    <p><?= e(cfg('doctor')) ?> is a clinical physiotherapist (<?= e(cfg('qualification')) ?>) practising at <?= e(cfg('clinic_name')) ?>, <?= e(cfg('address')) ?>. Care begins with a careful assessment of how you move, so that treatment is aimed at the cause of your problem and not only the pain.</p>
    <h3>Qualifications &amp; certifications</h3>
    <ul class="ticks"><?php foreach (cfg('credentials') as $q): ?><li><?= icon('check',18) ?> <?= e($q) ?></li><?php endforeach; ?></ul>
    <h3>Hospital training</h3>
    <ul class="ticks"><?php foreach (cfg('experience_list') as $q): ?><li><?= icon('check',18) ?> <?= e($q) ?></li><?php endforeach; ?></ul>
    <h3>Philosophy of care</h3>
    <p>Pain is a symptom. We look for the cause, explain it in plain language, and design a program you can actually follow. If your condition needs a medical doctor, tests or surgery, you will be advised honestly and referred to the right specialist.</p>
    <a class="btn" href="<?= e(url('book')) ?>">Book a consultation</a>
  </div>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
