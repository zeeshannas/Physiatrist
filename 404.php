<?php
require_once __DIR__ . '/includes/functions.php';
http_response_code(404);
$seo = ['title'=>'Page not found | ' . cfg('doctor'), 'path'=>'404', 'noindex'=>true];
include __DIR__ . '/includes/header.php';
?>
<section class="page-h"><div class="wrap"><h1>404 - Page not found</h1><p>The page you are looking for does not exist.</p><a class="btn btn-light" href="<?= e(url()) ?>">Go to homepage</a></div></section>
<?php include __DIR__ . '/includes/footer.php'; ?>
