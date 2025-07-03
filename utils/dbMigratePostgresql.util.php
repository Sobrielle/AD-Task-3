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

// 3. Connect to PostgreSQL
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

// 4. Drop old tables
echo "Dropping old tables…\n";

// Drop in reverse dependency order (children → parents)
$tablesToDrop = [
    'tasks',
    'meeting_users',
    'meeting',
    'users'
];

foreach ($tablesToDrop as $table) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
        echo "✅ Dropped table: {$table}\n";
    } catch (PDOException $e) {
        echo "❌ Failed to drop {$table}: " . $e->getMessage() . "\n";
    }
}

// 5. Re-apply schema files
echo "Applying schemas…\n";

$modelFiles = [
    'users.model.sql',
    'meeting.model.sql',
    'meeting_users.model.sql',
    'tasks.model.sql'
];

foreach ($modelFiles as $file) {
    $filePath = __DIR__ . '/../database/' . $file;
    echo "🔄 Applying schema from {$filePath}...\n";

    $sql = file_get_contents($filePath);

    if ($sql === false) {
        echo "❌ Could not read {$filePath}\n";
        continue;
    }

    try {
        $pdo->exec($sql);
        echo "✅ Created schema from {$file}\n";
    } catch (PDOException $e) {
        echo "❌ Error applying {$file}: " . $e->getMessage() . "\n";
    }
}

echo "🎉 ✅ Database migration completed successfully!\n";
