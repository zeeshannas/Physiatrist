<?php
require_once __DIR__ . '/functions.php';
$S = seo($seo ?? []);
$schemas = array_merge([schema_physician()], $S['schema']);
$canon = abs_url($S['path']);
$nav = ['' => 'Home', 'about' => 'About', 'services' => 'Services', 'blog' => 'Health Blog', 'faq' => 'FAQ', 'contact' => 'Contact'];
$cur = trim($S['path'], '/');
$cur = explode('/', $cur)[0];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($S['title']) ?></title>
<meta name="description" content="<?= e($S['desc']) ?>">
<?php if ($S['keywords']): ?><meta name="keywords" content="<?= e($S['keywords']) ?>"><?php endif; ?>
<meta name="robots" content="<?= $S['noindex'] ? 'noindex,nofollow' : 'index,follow,max-image-preview:large' ?>">
<link rel="canonical" href="<?= e($canon) ?>">
<meta property="og:type" content="<?= e($S['type']) ?>">
<meta property="og:title" content="<?= e($S['title']) ?>">
<meta property="og:description" content="<?= e($S['desc']) ?>">
<meta property="og:url" content="<?= e($canon) ?>">
<meta property="og:image" content="<?= e(abs_url('assets/img/og-cover.svg')) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="theme-color" content="#0e7c86">
<link rel="icon" href="<?= e(url('assets/img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<?php foreach ($schemas as $sc): ?>
<script type="application/ld+json"><?= json_encode($sc, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
<?php endforeach; ?>
</head>
<body>
<a class="skip" href="#main">Skip to content</a>
<div class="topbar">
  <div class="wrap">
    <span><?= icon('clock',16) ?> Mon-Sat 11AM-4PM</span>
    <span class="tb-right"><a href="tel:<?= e(preg_replace('/\s+/','',cfg('phone'))) ?>"><?= icon('phone',16) ?> <?= e(cfg('phone')) ?></a>
    <?php if (cfg('email')): ?><a href="mailto:<?= e(cfg('email')) ?>"><?= icon('mail',16) ?> <?= e(cfg('email')) ?></a><?php endif; ?>
</span>
  </div>
</div>
<header class="site-header" id="hdr">
  <div class="wrap hdr-in">
    <a class="logo" href="<?= e(url()) ?>" aria-label="<?= e(cfg('doctor')) ?> home">
      <span class="logo-mark"><?= icon('spine',26) ?></span>
      <span><b><?= e(cfg('doctor')) ?></b><small>Clinical Physiotherapist &middot; DPT</small></span>
    </a>
    <button class="burger" id="burger" aria-label="Menu" aria-expanded="false"><?= icon('menu',26) ?></button>
    <nav id="nav" aria-label="Main">
      <?php foreach ($nav as $p => $label): ?>
        <a href="<?= e(url($p)) ?>" class="<?= $cur === $p ? 'on' : '' ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
      <a class="btn btn-sm" href="<?= e(url('book')) ?>"><?= icon('calendar',16) ?> Book Appointment</a>
    </nav>
  </div>
</header>
<main id="main">
