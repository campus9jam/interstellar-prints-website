<?php
/**
 * Interstellar Prints Global Ltd. — Logistics / Delivery Booking Handler
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

// ─── Honeypot Check ─────────────────────────────────────────────────
if (!empty($_POST['website_url'])) {
    header('Location: success.html?ref=' . urlencode(generate_order_ref('LG')));
    exit;
}

// ─── Validate Required Fields ─────────────────────────────────────
$errors = [];

$pickup_location     = sanitize($_POST['pickup_location'] ?? '');
$dropoff_location    = sanitize($_POST['dropoff_location'] ?? '');
$package_description= sanitize($_POST['package_description'] ?? '');
$full_name           = sanitize($_POST['full_name'] ?? '');
$email               = sanitize($_POST['email'] ?? '');
$phone               = sanitize($_POST['phone'] ?? '');

if (empty($pickup_location))   $errors[] = 'Pickup location is required.';
if (empty($dropoff_location))  $errors[] = 'Drop-off location is required.';
if (empty($package_description)) $errors[] = 'Package description is required.';
if (empty($full_name))          $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if (empty($phone))              $errors[] = 'Phone number is required.';

if (!empty($errors)) {
    http_response_code(422);
    die(implode(' ', $errors));
}

// ─── Optional Fields ──────────────────────────────────────────────
$company_name   = sanitize($_POST['company_name'] ?? '');
$weight         = sanitize($_POST['weight'] ?? '');
$dimensions     = sanitize($_POST['dimensions'] ?? '');
$delivery_type  = sanitize($_POST['delivery_type'] ?? 'standard');
$pickup_date    = sanitize($_POST['pickup_date'] ?? '');
if (empty($pickup_date)) $pickup_date = null;

// ─── Generate Order Reference ─────────────────────────────────────
$order_ref = generate_order_ref('LG');

// ─── Insert into Database ─────────────────────────────────────────
try {
    $pdo = get_db();
    $stmt = $pdo->prepare("
        INSERT INTO logistics_bookings
            (order_ref, pickup_location, dropoff_location, package_description,
             weight, dimensions, delivery_type, full_name, company_name,
             email, phone, pickup_date, submitted_at, status, ip_address, user_agent)
        VALUES
            (:order_ref, :pickup_location, :dropoff_location, :package_description,
             :weight, :dimensions, :delivery_type, :full_name, :company_name,
             :email, :phone, :pickup_date, NOW(), 'new', :ip_address, :user_agent)
    ");

    $stmt->execute([
        ':order_ref'           => $order_ref,
        ':pickup_location'     => $pickup_location,
        ':dropoff_location'    => $dropoff_location,
        ':package_description'=> $package_description,
        ':weight'             => $weight,
        ':dimensions'          => $dimensions,
        ':delivery_type'       => $delivery_type,
        ':full_name'           => $full_name,
        ':company_name'        => $company_name,
        ':email'               => $email,
        ':phone'               => $phone,
        ':pickup_date'         => $pickup_date,
        ':ip_address'          => $_SERVER['REMOTE_ADDR'] ?? null,
        ':user_agent'          => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
    ]);
} catch (PDOException $e) {
    error_log('Logistics insert failed: ' . $e->getMessage());
    http_response_code(500);
    die('Server error. Please try again later or contact us directly.');
}

// ─── Send Email Notification ──────────────────────────────────────
$email_data = [
    'Pickup Location'       => $pickup_location,
    'Drop-off Location'     => $dropoff_location,
    'Package Description'   => $package_description,
    'Estimated Weight (kg)' => $weight,
    'Dimensions'            => $dimensions,
    'Delivery Type'         => ucfirst($delivery_type),
    'Full Name'             => $full_name,
    'Company Name'          => $company_name,
    'Email'                 => $email,
    'Phone'                 => $phone,
    'Preferred Pickup Date' => $pickup_date ?? 'Not specified',
    'Submitted At'          => date('Y-m-d H:i:s'),
    'Customer IP'           => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
];

send_order_email(COMPANY_EMAIL, 'New Delivery Booking: ' . $order_ref, $order_ref, $email_data, 'logistics');

// ─── Redirect to Success Page ─────────────────────────────────────
header('Location: success.html?ref=' . urlencode($order_ref) . '&type=logistics');
exit;
