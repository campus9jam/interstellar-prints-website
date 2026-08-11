<?php
/**
 * Interstellar Prints Global Ltd. — Stationery / Merchandise Quote Handler
 * Receives form submissions, validates, stores in DB, emails the company.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/mail.php';

session_start();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method not allowed.');
}

// ─── CSRF Check ────────────────────────────────────────────────────
if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    die('Security token expired. Please refresh the page and try again.');
}

// ─── Honeypot Check ────────────────────────────────────────────────
if (!empty($_POST['website_url'])) {
    // Bot filled the hidden field — pretend success but do nothing
    header('Location: success.html?ref=' . urlencode(generate_order_ref('SQ')));
    exit;
}

// ─── Validate Required Fields ─────────────────────────────────────
$errors = [];

$item_type = sanitize($_POST['item_type'] ?? '');
$quantity  = (int)($_POST['quantity'] ?? 0);
$full_name = sanitize($_POST['full_name'] ?? '');
$email     = sanitize($_POST['email'] ?? '');
$phone     = sanitize($_POST['phone'] ?? '');

if (empty($item_type))     $errors[] = 'Item type is required.';
if ($quantity < 1)         $errors[] = 'Quantity must be at least 1.';
if (empty($full_name))     $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if (empty($phone))         $errors[] = 'Phone number is required.';

if (!empty($errors)) {
    http_response_code(422);
    die(implode(' ', $errors));
}

// ─── Optional Fields ──────────────────────────────────────────────
$branding_requirements = sanitize($_POST['branding_requirements'] ?? '');
$company_name          = sanitize($_POST['company_name'] ?? '');
$additional_details    = sanitize($_POST['additional_details'] ?? '');

// ─── Generate Order Reference ─────────────────────────────────────
$order_ref = generate_order_ref('SQ');

// ─── Insert into Database ─────────────────────────────────────────
try {
    $pdo = get_db();
    $stmt = $pdo->prepare("
        INSERT INTO quote_requests
            (order_ref, item_type, quantity, branding_requirements,
             full_name, company_name, email, phone, additional_details,
             submitted_at, status, ip_address, user_agent)
        VALUES
            (:order_ref, :item_type, :quantity, :branding_requirements,
             :full_name, :company_name, :email, :phone, :additional_details,
             NOW(), 'new', :ip_address, :user_agent)
    ");

    $stmt->execute([
        ':order_ref'            => $order_ref,
        ':item_type'            => $item_type,
        ':quantity'             => $quantity,
        ':branding_requirements'=> $branding_requirements,
        ':full_name'            => $full_name,
        ':company_name'         => $company_name,
        ':email'                => $email,
        ':phone'                => $phone,
        ':additional_details'   => $additional_details,
        ':ip_address'           => $_SERVER['REMOTE_ADDR'] ?? null,
        ':user_agent'           => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
    ]);
} catch (PDOException $e) {
    error_log('Quote insert failed: ' . $e->getMessage());
    http_response_code(500);
    die('Server error. Please try again later or contact us directly.');
}

// ─── Send Email Notification ──────────────────────────────────────
$email_data = [
    'Item Type'              => $item_type,
    'Quantity'               => $quantity,
    'Branding Requirements'  => $branding_requirements,
    'Full Name'              => $full_name,
    'Company Name'           => $company_name,
    'Email'                  => $email,
    'Phone'                  => $phone,
    'Additional Details'     => $additional_details,
    'Submitted At'           => date('Y-m-d H:i:s'),
    'Customer IP'            => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
];

send_order_email(COMPANY_EMAIL, 'New Quote Request: ' . $order_ref, $order_ref, $email_data, 'quote');

// ─── Redirect to Success Page ─────────────────────────────────────
header('Location: success.html?ref=' . urlencode($order_ref) . '&type=quote');
exit;
