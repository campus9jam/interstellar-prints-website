<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/config.php';

echo "Config loaded OK\n";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_CHARSET: " . DB_CHARSET . "\n\n";

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET),
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "DB connection: OK\n\n";

    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . (empty($tables) ? "(none)" : implode(', ', $tables)) . "\n\n";

    foreach (['quote_requests', 'logistics_bookings', 'newsletter_subscribers'] as $t) {
        if (in_array($t, $tables)) {
            $cols = $pdo->query("DESCRIBE `$t`")->fetchAll(PDO::FETCH_COLUMN);
            echo "$t columns: " . implode(', ', $cols) . "\n";
        } else {
            echo "$t: MISSING\n";
        }
    }
} catch (PDOException $e) {
    echo "DB ERROR: " . $e->getMessage() . "\n";
}
