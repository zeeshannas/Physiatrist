<?php
require_once __DIR__ . '/includes/functions.php';
header('Content-Type: application/xml; charset=utf-8');
$urls = [['',1.0],['about',0.8],['services',0.9],['blog',0.8],['faq',0.6],['contact',0.7],['book',0.9]];
foreach ($SERVICES as $k => $_) $urls[] = ['services/'.$k, 0.8];
foreach ($CONTENT['articles'] as $k => $a) $urls[] = ['blog/'.$k, 0.7, $a['date']];
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
  <url><loc><?= e(abs_url($u[0])) ?></loc><lastmod><?= e($u[2] ?? date('Y-m-d')) ?></lastmod><priority><?= number_format($u[1],1) ?></priority></url>
<?php endforeach; ?>
</urlset>
