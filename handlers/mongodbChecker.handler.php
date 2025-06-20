<?php
require_once __DIR__ . '/../envSetter.util.php';

try {
    $mongo = new MongoDB\Driver\Manager(
        "mongodb://{$_ENV['MONGO_HOST']}:{$_ENV['MONGO_PORT']}"
    );

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully. <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . " <br>";
}
