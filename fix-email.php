<?php
header('Content-Type: text/plain');

if (($_GET['key'] ?? '') !== '0fdee54f6afb5accd2dcf26c7297162c') {
    http_response_code(403);
    die('Forbidden');
}

$file = __DIR__ . '/config.php';
$content = file_get_contents($file);

if ($content === false) {
    die('Cannot read config.php');
}

$original = $content;

// Fix COMPANY_EMAIL - keep the same prefix but use .com.ng domain
$content = preg_replace(
    "/define\('COMPANY_EMAIL',\s*'[^']*'\)/",
    "define('COMPANY_EMAIL', 'orders@interstellarprints.com.ng')",
    $content
);

// Fix SENDER_EMAIL - must be a real mailbox on the hosting domain
$content = preg_replace(
    "/define\('SENDER_EMAIL',\s*'[^']*'\)/",
    "define('SENDER_EMAIL', 'noreply@interstellarprints.com.ng')",
    $content
);

// Fix SITE_URL
$content = preg_replace(
    "/define\('SITE_URL',\s*'[^']*'\)/",
    "define('SITE_URL', 'https://interstellarprints.com.ng')",
    $content
);

if ($content === $original) {
    echo "No changes needed - values already correct.\n";
} else {
    $result = file_put_contents($file, $content);
    if ($result === false) {
        die('Failed to write config.php');
    }
    echo "config.php updated successfully!\n";
    echo "Changes:\n";
    echo "- COMPANY_EMAIL -> orders@interstellarprints.com.ng\n";
    echo "- SENDER_EMAIL -> noreply@interstellarprints.com.ng\n";
    echo "- SITE_URL -> https://interstellarprints.com.ng\n";
}

echo "\n=== Verification ===\n";
require $file;
echo "COMPANY_EMAIL: " . COMPANY_EMAIL . "\n";
echo "SENDER_EMAIL: " . SENDER_EMAIL . "\n";
echo "SITE_URL: " . SITE_URL . "\n";

echo "\n=== Sending test email ===\n";
$subject = 'Interstellar Prints - Email Fix Test ' . date('Y-m-d H:i:s');
$body = '<h2>Test Email</h2><p>If you received this, order notifications will work now.</p>';
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . COMPANY_NAME . ' <' . SENDER_EMAIL . '>',
];
$sent = mail(COMPANY_EMAIL, $subject, $body, implode("\r\n", $headers));
echo "mail() returned: " . ($sent ? 'true (sent)' : 'false (FAILED)') . "\n";
echo "Check orders@interstellarprints.com.ng inbox for the test email.\n";
