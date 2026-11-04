<?php
// Sirf local testing ke liye (php -S). Apache par .htaccess ye kaam karta hai.
$p = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$blocked = '#^/(storage|includes|data|cron)(/|$)|^/(config|router)\.php$#';
if (preg_match($blocked, $p)) { http_response_code(403); exit('Forbidden'); }
if ($p !== '/' && is_file(__DIR__ . $p)) return false;
if (is_dir(__DIR__ . $p) && is_file(__DIR__ . rtrim($p, '/') . '/index.php')) { require __DIR__ . rtrim($p, '/') . '/index.php'; return; }
if (preg_match('#^/services/([a-z0-9-]+)/?$#', $p, $m)) { $_GET['slug'] = $m[1]; require 'service.php'; return; }
if (preg_match('#^/blog/([a-z0-9-]+)/?$#', $p, $m)) { $_GET['slug'] = $m[1]; require 'article.php'; return; }
if ($p === '/sitemap.xml') { require 'sitemap.php'; return; }
if ($p === '/robots.txt') { require 'robots.php'; return; }
$f = trim($p, '/');
if ($f === '') { require 'index.php'; return; }
if (preg_match('#^[a-z0-9-]+$#', $f) && is_file("$f.php")) { require "$f.php"; return; }
require '404.php';
