<?php
require_once __DIR__ . '/includes/functions.php';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($_GET['slug'] ?? ''));
if (!isset($CONTENT['articles'][$slug])) { http_response_code(404); include __DIR__ . '/404.php'; exit; }
$a = $CONTENT['articles'][$slug];
$seo = [
  'title' => $a['title'] . ' | ' . cfg('doctor'),
  'desc'  => $a['desc'], 'type' => 'article', 'path' => 'blog/' . $slug,
  'schema'=> [
    breadcrumb_schema(['Home'=>'','Blog'=>'blog',$a['title']=>'blog/'.$slug]),
    ['@context'=>'https://schema.org','@type'=>'MedicalWebPage','headline'=>$a['title'],'description'=>$a['desc'],
     'datePublished'=>$a['date'],'dateModified'=>$a['date'],'image'=>abs_url('assets/img/og-cover.svg'),
     'author'=>['@type'=>'Person','name'=>cfg('doctor')],'reviewedBy'=>['@type'=>'Person','name'=>cfg('doctor')],
     'publisher'=>['@type'=>'Organization','name'=>cfg('clinic_name')],'mainEntityOfPage'=>abs_url('blog/'.$slug)],
  ],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / <a href="<?= e(url('blog')) ?>">Blog</a></nav>
<h1><?= e($a['title']) ?></h1><p><?= e(date('F j, Y', strtotime($a['date']))) ?> &middot; <?= (int)$a['read'] ?> min read &middot; Reviewed by <?= e(cfg('doctor')) ?></p></div></section>
<section class="sec"><div class="wrap article-grid">
  <article class="prose">
    <p class="lead"><?= e($a['desc']) ?></p>
    <?php foreach ($a['sections'] as $sec): ?><h2><?= e($sec[0]) ?></h2><p><?= e($sec[1]) ?></p><?php endforeach; ?>
    <div class="note">This article is for education and does not replace personal medical advice. <a href="<?= e(url('book')) ?>">Book a consultation</a> for your specific condition.</div>
  </article>
  <aside class="side">
    <div class="side-box tilt"><h3>Need help?</h3><p>Talk to <?= e(cfg('doctor')) ?> about your symptoms.</p><a class="btn" href="<?= e(url('book')) ?>">Book Appointment</a></div>
    <div class="side-box"><h3>More articles</h3><?php foreach ($CONTENT['articles'] as $k => $o): if ($k === $slug) continue; ?><a class="sl" href="<?= e(url('blog/'.$k)) ?>"><?= e($o['title']) ?></a><?php endforeach; ?></div>
  </aside>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
