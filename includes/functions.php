<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) { @session_start(); }

$CFG = require __DIR__ . '/../config.php';
date_default_timezone_set($CFG['timezone']);
$SERVICES = require __DIR__ . '/../data/services.php';
$CONTENT  = require __DIR__ . '/../data/content.php';

function cfg(string $k, $d = null) { global $CFG; return $CFG[$k] ?? $d; }
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/** Folder ka base path, e.g. "/Physiatrist" ya "" */
function base_path(): string {
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $dir = preg_replace('#/(api|admin|cron)$#', '', $dir);
    return rtrim($dir, '/');
}
function site_url(): string {
    if (cfg('site_url')) return rtrim(cfg('site_url'), '/');
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    return ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . base_path();
}
function url(string $path = ''): string { return base_path() . '/' . ltrim($path, '/'); }
function abs_url(string $path = ''): string { return site_url() . '/' . ltrim($path, '/'); }
function asset(string $p): string {
    $f = __DIR__ . '/../' . ltrim($p, '/');
    return url($p) . (is_file($f) ? '?v=' . filemtime($f) : '');
}

/**
 * Real photo support: assets/img/photos/<name>.jpg (ya .webp/.png) rakh dein to wo khud use hoga,
 * warna default SVG illustration dikhegi. Names: hero, clinic, doctor
 */
function photo(string $name, string $fallback): string {
    foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
        if (is_file(__DIR__ . "/../assets/img/photos/$name.$ext")) return asset("assets/img/photos/$name.$ext");
    }
    return asset("assets/img/$fallback");
}

/* ---------- Icons (inline SVG, no external files) ---------- */
function icon(string $n, int $s = 28): string {
    $paths = [
     'spine'  => '<path d="M12 2c2 1 2 3 0 4 2 1 2 3 0 4 2 1 2 3 0 4 2 1 2 3 0 4 2 1 2 2 0 4"/>',
     'neck'   => '<circle cx="12" cy="6" r="3"/><path d="M8 22v-6a4 4 0 0 1 8 0v6M10 10l-1 4M14 10l1 4"/>',
     'brain'  => '<path d="M9 4a3 3 0 0 0-3 3 3 3 0 0 0-2 5 3 3 0 0 0 2 5 3 3 0 0 0 6 1V4a3 3 0 0 0-3 0zM15 4a3 3 0 0 1 3 3 3 3 0 0 1 2 5 3 3 0 0 1-2 5 3 3 0 0 1-6 1"/>',
     'sport'  => '<circle cx="14" cy="5" r="2"/><path d="M6 21l4-7 3 2 3-6-3-2-3 2-3 3M16 10l4 2"/>',
     'knee'   => '<path d="M9 2v8l-2 4 3 3v5M15 2v8l2 4-3 3v5"/><circle cx="12" cy="13" r="2"/>',
     'nerve'  => '<path d="M4 4c4 0 4 6 8 6s4-6 8-6M4 20c4 0 4-6 8-6s4 6 8 6"/>',
     'child'  => '<circle cx="12" cy="5" r="3"/><path d="M6 21v-6a6 6 0 0 1 12 0v6M9 21v-4M15 21v-4"/>',
     'doctor' => '<circle cx="12" cy="7" r="4"/><path d="M4 21v-2a6 6 0 0 1 16 0v2M12 14v5M9.5 16.5h5"/>',
     'phone'  => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
     'pin'    => '<path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
     'clock'  => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
     'mail'   => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
     'check'  => '<path d="M20 6 9 17l-5-5"/>',
     'star'   => '<path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/>',
     'chat'   => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
     'calendar'=> '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
     'arrow'  => '<path d="M5 12h14M13 5l7 7-7 7"/>',
     'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
     'wa'     => '<path d="M3 21l1.6-4.7A8.5 8.5 0 1 1 8 19.6z"/><path d="M9 10c0 3 3 6 6 6l1.5-1.5-2-1-1 .7c-1-.4-2-1.4-2.4-2.4l.7-1-1-2z"/>',
     'menu'   => '<path d="M3 6h18M3 12h18M3 18h18"/>',
     'facebook'=> '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
     'instagram'=> '<rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/>',
     'youtube'=> '<path d="M22.5 7.2a2.7 2.7 0 0 0-1.9-1.9C19 4.8 12 4.8 12 4.8s-7 0-8.6.5A2.7 2.7 0 0 0 1.5 7.2 28 28 0 0 0 1 12a28 28 0 0 0 .5 4.8 2.7 2.7 0 0 0 1.9 1.9c1.6.5 8.6.5 8.6.5s7 0 8.6-.5a2.7 2.7 0 0 0 1.9-1.9A28 28 0 0 0 23 12a28 28 0 0 0-.5-4.8z"/><path d="m10 15 5-3-5-3z"/>',
     'linkedin'=> '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/>',
     'up'     => '<path d="M12 19V5M5 12l7-7 7 7"/>',
     'needle' => '<path d="M20 4 4 20M17 3l4 4M7 17l-3 3"/><path d="m14 6 4 4"/>',
     'tape'   => '<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.5"/><path d="M21 12h2"/>',
     'cup'    => '<path d="M5 8h14l-1.5 9a3 3 0 0 1-3 2.5h-5a3 3 0 0 1-3-2.5z"/><path d="M9 8V5h6v3"/>',
     'dumbbell'=> '<path d="M6 7v10M18 7v10M3 10v4M21 10v4M6 12h12"/>',
     'send'   => '<path d="m22 2-11 11M22 2l-7 20-4-9-9-4z"/>',
    ];
    $p = $paths[$n] ?? $paths['doctor'];
    return '<svg class="ico" width="'.$s.'" height="'.$s.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p.'</svg>';
}

/* ---------- SEO ---------- */
function seo(array $o = []): array {
    return array_merge([
        'title' => cfg('site_name'),
        'desc'  => 'Consult ' . cfg('doctor') . ', clinical physiotherapist (DPT) in ' . cfg('city') . ' for back pain, neck pain, stroke rehabilitation, sports injury and nerve pain. Book online.',
        'path'  => '', 'type' => 'website', 'schema' => [], 'keywords' => '', 'noindex' => false,
    ], $o);
}
function schema_physician(): array {
    return [
      '@context'=>'https://schema.org','@type'=>['Physiotherapy','MedicalBusiness'],
      'name'=>cfg('clinic_name'),'founder'=>['@type'=>'Person','name'=>cfg('doctor'),'jobTitle'=>'Clinical Physiotherapist'],
      'url'=>site_url(),'telephone'=>cfg('phone'),
      'image'=>abs_url('assets/img/og-cover.svg'),
      'address'=>['@type'=>'PostalAddress','streetAddress'=>cfg('address'),'addressLocality'=>cfg('city'),'addressCountry'=>cfg('country')],
      'geo'=>['@type'=>'GeoCoordinates','latitude'=>cfg('geo')['lat'],'longitude'=>cfg('geo')['lng']],
      'openingHours'=>cfg('opening_hours'),
      'priceRange'=>'$$',
    ];
}
function breadcrumb_schema(array $items): array {
    $list = []; $i = 1;
    foreach ($items as $name => $path) {
        $list[] = ['@type'=>'ListItem','position'=>$i++,'name'=>$name,'item'=>abs_url($path)];
    }
    return ['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>$list];
}
function faq_schema(array $faqs): array {
    return ['@context'=>'https://schema.org','@type'=>'FAQPage','mainEntity'=>array_map(fn($f)=>[
        '@type'=>'Question','name'=>$f[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$f[1]]
    ], $faqs)];
}

/* ---------- Security ---------- */
function app_secret(): string {
    return getenv("APP_SECRET") ?: hash("sha256", cfg("admin_password") . "|physiatrist-site");
}
/** Stateless CSRF token (serverless-safe): "<time>.<hmac>" */
function csrf_token(): string {
    $t = (string)time();
    return $t . "." . hash_hmac("sha256", "csrf|" . $t, app_secret());
}
function csrf_check(?string $tok): bool {
    if (!is_string($tok) || !str_contains($tok, ".")) return false;
    [$t, $sig] = explode(".", $tok, 2);
    if (!ctype_digit($t) || (time() - (int)$t) > 21600 || (int)$t > time() + 60) return false;
    return hash_equals(hash_hmac("sha256", "csrf|" . $t, app_secret()), $sig);
}
/** Admin login via signed cookie (no server session needed) */
function admin_ok(): bool {
    $c = $_COOKIE["adm"] ?? "";
    if (!str_contains($c, ".")) return false;
    [$t, $sig] = explode(".", $c, 2);
    return ctype_digit($t) && (time() - (int)$t) < 28800 && hash_equals(hash_hmac("sha256", "adm|" . $t, app_secret()), $sig);
}
function admin_login(): void {
    $t = (string)time();
    $https = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") || ($_SERVER["HTTP_X_FORWARDED_PROTO"] ?? "") === "https";
    setcookie("adm", $t . "." . hash_hmac("sha256", "adm|" . $t, app_secret()), ["expires"=>time()+28800,"path"=>"/","httponly"=>true,"secure"=>$https,"samesite"=>"Lax"]);
}
function admin_logout(): void { setcookie("adm", "", ["expires"=>time()-3600,"path"=>"/"]); }
/* ---------- Storage (JSON file, locked) ---------- */
function store_path(): string {
    $dir = __DIR__ . '/../storage';
    // Vercel/serverless: project folder read-only hota hai, isliye /tmp use hota hai (temporary!)
    if (!is_dir($dir) || !is_writable($dir)) return sys_get_temp_dir() . '/appointments.json';
    return $dir . '/appointments.json';
}
function appointments_all(): array {
    $f = store_path();
    if (!is_file($f)) return [];
    return json_decode((string)file_get_contents($f), true) ?: [];
}
function appointments_save(array $rows): void {
    file_put_contents(store_path(), json_encode(array_values($rows), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX);
}
function slot_taken(string $date, string $time): bool {
    foreach (appointments_all() as $a) {
        if ($a['date'] === $date && $a['time'] === $time && $a['status'] !== 'cancelled') return true;
    }
    return false;
}
function wa_link(string $msg = ''): string {
    return 'https://wa.me/' . cfg('whatsapp') . ($msg ? '?text=' . rawurlencode($msg) : '');
}
/** Local number (03xx...) ko international format (92 3xx...) mein badalta hai */
function wa_phone(string $p): string {
    $p = preg_replace('/\D/', '', $p);
    if (str_starts_with($p, '00')) return substr($p, 2);
    if (str_starts_with($p, '0')) return cfg('country_code', '92') . substr($p, 1);
    return $p;
}
function fmt_time(string $t): string { return date('g:i A', strtotime($t)); }

/* ---------- Service images (photo dalne par khud use hoti hai: assets/img/services/<slug>.jpg) ---------- */
function service_img(string $slug): string {
    foreach (['jpg','webp','png'] as $ext) {
        if (is_file(__DIR__ . "/../assets/img/services/$slug.$ext")) return asset("assets/img/services/$slug.$ext");
    }
    return asset("assets/img/services/$slug.svg");
}
function service_card_legacy(string $slug, array $s): string {
    return '<a class="card scard tilt reveal" href="' . e(url('services/' . $slug)) . '">'
        . '<span class="s-img"><img src="' . e(service_img($slug)) . '" alt="' . e($s['title']) . '" width="400" height="280" loading="lazy"></span>'
        . '<span class="s-body"><h3>' . e($s['title']) . '</h3>'
        . '<p>' . e($s['short']) . '</p>'
        . '<span class="more">Learn more ' . icon('arrow', 16) . '</span></span></a>';
}

/** Modern service card (image + glass badge + number + arrow button) */
function service_card(string $slug, array $s): string {
    global $SERVICES;
    $idx = array_search($slug, array_keys($SERVICES), true);
    $num = str_pad((string)(($idx === false ? 0 : $idx) + 1), 2, '0', STR_PAD_LEFT);
    return '<a class="card scard tilt reveal" href="' . e(url('services/' . $slug)) . '">'
        . '<span class="s-img"><img src="' . e(service_img($slug)) . '" alt="' . e($s['title']) . '" width="400" height="280" loading="lazy">'
        . '<span class="s-badge">' . icon($s['icon'], 22) . '</span><span class="s-num">' . $num . '</span></span>'
        . '<span class="s-body"><h3>' . e($s['title']) . '</h3><p>' . e($s['short']) . '</p>'
        . '<span class="s-foot"><span class="s-more">Learn more</span><span class="s-go">' . icon('arrow', 18) . '</span></span></span></a>';
}
