<?php
require_once __DIR__ . '/includes/functions.php';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['slug'] ?? ''));
if (!isset($SERVICES[$slug])) { http_response_code(404); include __DIR__ . '/404.php'; exit; }
$s = $SERVICES[$slug];
$seo = [
  'title' => $s['title'] . ' in ' . cfg('city') . ' | ' . cfg('doctor'),
  'desc'  => $s['short'] . ' Consult ' . cfg('doctor') . ' in ' . cfg('city') . '.',
  'keywords' => $s['keywords'] . ', ' . cfg('city'),
  'path'  => 'services/' . $slug,
  'schema'=> [
    breadcrumb_schema(['Home'=>'','Services'=>'services',$s['title']=>'services/'.$slug]),
    ['@context'=>'https://schema.org','@type'=>'MedicalProcedure','name'=>$s['title'],'description'=>$s['short'],
     'provider'=>['@type'=>'Physician','name'=>cfg('doctor')],'url'=>abs_url('services/'.$slug)],
    faq_schema(array_slice($CONTENT['faqs'], 0, 4)),
  ],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / <a href="<?= e(url('services')) ?>">Services</a> / <?= e($s['title']) ?></nav>
<h1><?= e($s['title']) ?> in <?= e(cfg('city')) ?></h1><p><?= e($s['short']) ?></p></div></section>
<section class="sec"><div class="wrap article-grid">
  <article class="prose">
    <div class="svc-hero"><img src="<?= e(service_img($slug)) ?>" alt="<?= e($s['title']) ?>" width="400" height="280"></div>
    <?php foreach ($s['body'] as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
    <h2>Benefits of treatment with <?= e(cfg('doctor')) ?></h2>
    <ul class="ticks"><?php foreach ($s['benefits'] as $b): ?><li><?= icon('check',18) ?> <?= e($b) ?></li><?php endforeach; ?></ul>
    <h2>Common questions</h2>
    <?php foreach (array_slice($CONTENT['faqs'], 0, 4) as $f): ?><details class="faq"><summary><?= e($f[0]) ?></summary><p><?= e($f[1]) ?></p></details><?php endforeach; ?>
  </article>
  <aside class="side">
    <div class="side-box tilt"><span class="card-ico"><?= icon($s['icon'],30) ?></span><h3>Book a visit</h3><p>Get a personal assessment for <?= e(strtolower($s['title'])) ?>.</p>
      <a class="btn" href="<?= e(url('book?service='.$slug)) ?>">Book Appointment</a>
      <a class="btn btn-outline" href="<?= e(wa_link('Hello, I need help with '.$s['title'])) ?>" target="_blank" rel="noopener">WhatsApp</a></div>
    <div class="side-box"><h3>Other services</h3>
      <?php foreach ($SERVICES as $k => $o): if ($k === $slug) continue; ?><a class="sl" href="<?= e(url('services/'.$k)) ?>"><?= e($o['title']) ?></a><?php endforeach; ?></div>
  </aside>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
