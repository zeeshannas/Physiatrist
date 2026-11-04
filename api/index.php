<?php
/**
 * Vercel entry point: saare pretty URLs (/, /about, /services/xyz, /admin/ ...) yahan se router.php mein jate hain.
 * Local/Apache par is file ki zaroorat nahi.
 */
chdir(dirname(__DIR__));
$_SERVER['SCRIPT_NAME'] = '/api/index.php';
$res = require dirname(__DIR__) . '/router.php';
if ($res === false) {
    http_response_code(404);
    echo 'Not found';
}
