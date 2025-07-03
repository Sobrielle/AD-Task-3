<?php
declare(strict_types=1);

// 1. Load dependencies and environment
require 'vendor/autoload.php';
require 'bootstrap.php';
require_once __DIR__ . '/../utils/envSetter.util.php';

// 2. Load PostgreSQL config from .env
$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'db'   => $_ENV['PG_DB'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS'],
];

// 3. Establish PostgreSQL connection
try {
    $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
    $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "✅ Connected to PostgreSQL\n";
} catch (PDOException $e) {
    echo "❌ PostgreSQL connection failed: " . $e->getMessage() . "\n";
    exit(255);
}

// 4. Seeding Logic — add inside try-catch block
try {
    // Load dummy data file
    //$users = require_once __DIR__ . '/../staticData/dummies/users.staticData.php';
    $users = require_once DUMMIES_PATH . '/users.staticData.php';

    echo "Seeding users...\n";

    // Prepare insert statement
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password, full_name, email, role)
        VALUES (:username, :password, :full_name, :email, :role)
    ");

    // Execute insert for each user
    foreach ($users as $u) {
        $stmt->execute([
            ':username' => $u['username'],
            ':password' => password_hash($u['password'], PASSWORD_DEFAULT),
            ':full_name' => $u['full_name'],
            ':email' => $u['email'],
            ':role' => $u['role'],
        ]);
    }

    echo "✅ PostgreSQL seeding complete!\n";
} catch (Exception $e) {
    echo "❌ Error during seeding: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n"; // Optional: debug details
    exit(255);
}
