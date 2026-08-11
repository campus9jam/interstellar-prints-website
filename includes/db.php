<?php
/**
 * Interstellar Prints Global Ltd. — Database Connection (PDO)
 * Returns a PDO instance. Dies with a user-friendly message on failure.
 */

require_once __DIR__ . '/../config.php';

function get_db() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_PERSISTENT         => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log('Database connection failed: ' . $e->getMessage());
        http_response_code(500);
        die('Server error. Please try again later.');
    }

    return $pdo;
}

/**
 * Generate a unique order reference.
 * @param string $prefix 'SQ' for stationery quotes, 'LG' for logistics
 * @return string e.g. SQ-20260806-A1B2C
 */
function generate_order_ref($prefix) {
    $date = date('Ymd');
    $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
    return $prefix . '-' . $date . '-' . $random;
}

/**
 * Generate (or reuse) a CSRF token stored in the session.
 * IMPORTANT: session_start() must be called before this runs.
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify a submitted CSRF token against the one stored in the session.
 * IMPORTANT: session_start() must be called before this runs.
 */
function verify_csrf($token) {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize input for storage/display.
 */
function sanitize($value) {
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}
