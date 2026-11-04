<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'About ' . cfg('doctor') . ' | Physiatrist in ' . cfg('city'),
  'desc'  => 'Meet ' . cfg('doctor') . ', ' . cfg('qualification') . '. ' . cfg('experience') . '+ years of experience in non-surgical pain management and rehabilitation in ' . cfg('city') . '.',
  'path'  => 'about',
  'schema'=> [breadcrumb_schema(['Home'=>'','About'=>'about']), [
     '@context'=>'https://schema.org','@type'=>'Person','name'=>cfg('doctor'),'jobTitle'=>'Physiatrist',
     'worksFor'=>['@type'=>'MedicalBusiness','name'=>cfg('clinic_name')],'url'=>abs_url('about')]],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / About</nav><h1>About <?= e(cfg('doctor')) ?></h1><p><?= e(cfg('title_short')) ?></p></div></section>
<section class="sec"><div class="wrap two">
  <div class="about-img"><img src="<?= e(photo("doctor", "doctor.svg")) ?>" alt="<?= e(cfg('doctor')) ?>" width="420" height="480" loading="lazy"></div>
  <div class="prose">
    <h2>Compassionate, Evidence-Based Rehabilitation</h2>
    <p><?= e(cfg('doctor')) ?> is a physiatrist (Physical Medicine &amp; Rehabilitation specialist) practising in <?= e(cfg('city')) ?> with over <?= (int)cfg('experience') ?> years of experience. Patients travel from across the region for accurate diagnosis and non-surgical care of musculoskeletal pain, nerve problems and neurological disability.</p>
    <h3>Qualifications</h3>
    <ul class="ticks"><?php foreach (explode(',', cfg('qualification')) as $q): ?><li><?= icon('check',18) ?> <?= e(trim($q)) ?></li><?php endforeach; ?></ul>
    <h3>Philosophy of care</h3>
    <p>Pain is a symptom. We search for the true cause, explain it in plain language, and design a program you can actually follow. Surgery is recommended only when it is genuinely the best option.</p>
    <h3>Special interests</h3>
    <ul class="ticks"><li><?= icon('check',18) ?> Interventional pain management</li><li><?= icon('check',18) ?> Musculoskeletal ultrasound</li><li><?= icon('check',18) ?> Stroke &amp; spinal cord injury rehabilitation</li><li><?= icon('check',18) ?> EMG &amp; nerve conduction studies</li><li><?= icon('check',18) ?> Pediatric neurorehabilitation</li></ul>
    <a class="btn" href="<?= e(url('book')) ?>">Book a consultation</a>
  </div>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
