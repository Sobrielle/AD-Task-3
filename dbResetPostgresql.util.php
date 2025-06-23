<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Composer bootstrap
require 'bootstrap.php';

// 3) envSetter - using relative path instead of undefined constant
require_once __DIR__ . '/../utils/envSetter.util.php';

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Array of all SQL model files to process
$modelFiles = [
    'users.model.sql',
    'meeting.model.sql',
    'meeting_users_model.sql',
    'tasks.model.sql'
];

// Process each SQL file
foreach ($modelFiles as $file) {
    $filePath = 'database/' . $file;
    echo "Applying schema from {$filePath}...\n";
    
    $sql = file_get_contents($filePath);
    
    if ($sql === false) {
        throw new RuntimeException("Could not read {$filePath}");
    }
    
    try {
        $pdo->exec($sql);
        echo "Creation success for {$file}\n";
    } catch (PDOException $e) {
        echo "Error creating tables from {$file}: " . $e->getMessage() . "\n";
    }
}

// Truncate all tables (in proper order to respect foreign key constraints)
echo "Truncating tables...\n";
$tablesToTruncate = [
    'tasks',
    'meeting_users',
    'meeting',
    'users'
];

foreach ($tablesToTruncate as $table) {
    try {
        $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
        echo "Truncated {$table}\n";
    } catch (PDOException $e) {
        echo "Error truncating {$table}: " . $e->getMessage() . "\n";
    }
}

echo "Database reset completed successfully!\n";