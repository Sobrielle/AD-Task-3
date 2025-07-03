<?php
require_once UTILS_PATH . '/envSetter.util.php';

if (!class_exists('MongoDB\Driver\Manager')) {
    echo "⚠️ MongoDB extension not available. Skipping MongoDB check. <br>";
    return;
}

try {
    $mongo = new MongoDB\Driver\Manager($_ENV['MONGO_URI']);

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully. <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . " <br>";
}
