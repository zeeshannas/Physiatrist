<?php
require_once __DIR__ . '/includes/functions.php';
$seo = [
  'title' => 'FAQ - Physiotherapy Questions Answered | ' . cfg('doctor'),
  'desc'  => 'Answers to common questions about physiotherapy, dry needling, K-taping, rehabilitation, appointments and what to expect at your first visit.',
  'path'  => 'faq',
  'schema'=> [breadcrumb_schema(['Home'=>'','FAQ'=>'faq']), faq_schema($CONTENT['faqs'])],
];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><nav class="crumb"><a href="<?= e(url()) ?>">Home</a> / FAQ</nav><h1>Frequently Asked Questions</h1></div></section>
<section class="sec"><div class="wrap narrow">
<?php foreach ($CONTENT['faqs'] as $f): ?><details class="faq"><summary><?= e($f[0]) ?></summary><p><?= e($f[1]) ?></p></details><?php endforeach; ?>
</div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
