<?php
/**
 * Interstellar Prints Global Ltd. — Newsletter Signup Handler
 * Saves email to the newsletter_subscribers table.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method not allowed.');
}

// CSRF check
if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    die('Security token expired.');
}

// Honeypot
if (!empty($_POST['website_url'])) {
    echo json_encode(['success' => true]);
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(422);
    echo json_encode(['error' => 'Please enter a valid email address.']);
    exit;
}

try {
    $pdo = get_db();
    $stmt = $pdo->prepare("INSERT IGNORE INTO newsletter_subscribers (email, subscribed_at, ip_address) VALUES (:email, NOW(), :ip)");
    $stmt->execute([
        ':email' => $email,
        ':ip'    => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
} catch (PDOException $e) {
    error_log('Newsletter insert failed: ' . $e->getMessage());
}

// Redirect back with success flag
header('Location: index.php#newsletter-success');
exit;
