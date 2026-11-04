<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'Health Blog | Back Pain, Stroke, Knee & Rehab Tips - ' . cfg('doctor'),
  'desc'  => 'Expert articles on back pain, stroke recovery, knee arthritis and rehabilitation written by physiatrist ' . cfg('doctor') . '.',
  'path'  => 'blog',
  'schema'=> [breadcrumb_schema(['Home'=>'','Blog'=>'blog'])],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / Blog</nav><h1>Health Blog</h1><p>Practical advice from a physiatrist</p></div></section>
<section class="sec"><div class="wrap"><div class="grid cards">
<?php foreach ($CONTENT['articles'] as $slug => $a): ?>
  <a class="card tilt reveal" href="<?= e(url('blog/'.$slug)) ?>"><span class="card-ico"><?= icon($a['icon'],30) ?></span><small class="tag"><?= e($a['cat']) ?></small><h3><?= e($a['title']) ?></h3><p><?= e($a['desc']) ?></p><span class="more"><?= (int)$a['read'] ?> min read <?= icon('arrow',16) ?></span></a>
<?php endforeach; ?>
</div></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
