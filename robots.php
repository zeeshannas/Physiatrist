<?php
require_once __DIR__ . '/includes/functions.php';
header('Content-Type: text/plain; charset=utf-8');
?>User-agent: *
Allow: /
Disallow: <?= base_path() ?>/admin/
Disallow: <?= base_path() ?>/api/
Disallow: <?= base_path() ?>/storage/
Sitemap: <?= abs_url('sitemap.xml') ?>
