<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/config.php';

echo "=== Email Configuration Check ===\n";
echo "COMPANY_EMAIL: " . COMPANY_EMAIL . "\n";
echo "SENDER_EMAIL: " . SENDER_EMAIL . "\n";
echo "SITE_URL: " . SITE_URL . "\n";
echo "COMPANY_NAME: " . COMPANY_NAME . "\n";
echo "CONTACT_EMAIL: " . CONTACT_EMAIL . "\n\n";

echo "=== Domain Check ===\n";
$host = $_SERVER['HTTP_HOST'] ?? 'unknown';
echo "HTTP_HOST: $host\n";

// Check if sender domain matches host
$sender_domain = substr(strrchr(SENDER_EMAIL, '@'), 1);
echo "Sender domain: $sender_domain\n";
echo "Host domain: $host\n";
echo "Match: " . ($sender_domain === $host ? 'YES' : 'NO - THIS MAY CAUSE EMAIL FAILURES') . "\n\n";

echo "=== Mail Test ===\n";
$test_subject = 'Test from ' . COMPANY_NAME . ' - ' . date('Y-m-d H:i:s');
$test_body = '<h2>Email Test</h2><p>This is a diagnostic test from your website mail-test.php</p><p>If you see this, PHP mail() is working.</p>';
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . COMPANY_NAME . ' <' . SENDER_EMAIL . '>',
];
$result = mail(COMPANY_EMAIL, $test_subject, $test_body, implode("\r\n", $headers));
echo "mail() returned: " . ($result ? 'true (sent)' : 'false (FAILED)') . "\n";
echo "Last error: " . (error_get_last()['message'] ?? 'none') . "\n";
