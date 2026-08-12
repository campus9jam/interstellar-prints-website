<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/config.php';

if (($_GET['key'] ?? '') !== '7abb7e1d24179e913fa125e5f552e01d') {
    http_response_code(403);
    die('Forbidden');
}

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET),
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $alters = [
        "ALTER TABLE quote_requests ADD COLUMN ip_address VARCHAR(45) DEFAULT NULL",
        "ALTER TABLE quote_requests ADD COLUMN user_agent VARCHAR(255) DEFAULT NULL",
        "ALTER TABLE quote_requests ADD COLUMN admin_notes TEXT DEFAULT NULL",
        "ALTER TABLE quote_requests ADD COLUMN updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
        "ALTER TABLE logistics_bookings ADD COLUMN ip_address VARCHAR(45) DEFAULT NULL",
        "ALTER TABLE logistics_bookings ADD COLUMN user_agent VARCHAR(255) DEFAULT NULL",
        "ALTER TABLE logistics_bookings ADD COLUMN admin_notes TEXT DEFAULT NULL",
        "ALTER TABLE logistics_bookings ADD COLUMN updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP",
    ];

    foreach ($alters as $sql) {
        try {
            $pdo->exec($sql);
            echo "OK: $sql\n";
        } catch (PDOException $e) {
            echo "SKIP (" . $e->getMessage() . "): $sql\n";
        }
    }
    echo "\nMigration complete.\n";
} catch (PDOException $e) {
    echo "DB ERROR: " . $e->getMessage() . "\n";
}
