<?php
/**
 * Interstellar Prints Global Ltd. — Configuration
 * EDIT THESE VALUES to match your telehosting cPanel setup.
 */

// ─── Error Reporting ───────────────────────────────────────────────
// Set to 0 for production. Set to E_ALL while testing.
error_reporting(0);
ini_set('display_errors', 0);

// ─── Database Credentials ─────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_db_name');        // cPanel may prefix: username_dbname
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');
define('DB_CHARSET', 'utf8mb4');

// ─── Email Settings ────────────────────────────────────────────────
define('COMPANY_EMAIL', 'orders@yourdomain.com');   // Where customer orders get forwarded
define('SENDER_EMAIL', 'noreply@yourdomain.com');   // "From" address — MUST be on your domain
define('SITE_URL', 'https://yourdomain.com');
define('COMPANY_NAME', 'Interstellar Prints Global Ltd.');

// ─── Security ──────────────────────────────────────────────────────
// NOTE: CSRF tokens are now generated per-session automatically (see
// includes/db.php) — this constant is no longer used for that, but is
// kept here in case you want a app-wide secret for future use.
define('CSRF_SECRET', 'CHANGE_THIS_TO_A_LONG_RANDOM_STRING_abc123xyz789');

// ─── Contact Info (used in emails) ─────────────────────────────────
define('CONTACT_PHONE', '+234 704 524 6353');
define('CONTACT_WHATSAPP', '+234 811 111 0243');
define('CONTACT_ADDRESS', 'No 108 Sarkin Pawa Road, Zaria, Kaduna');
define('CONTACT_EMAIL', 'info@interstellarprints.com');
