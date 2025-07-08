<?php

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$isDocker = file_exists('/.dockerenv'); // Check if running inside a container

if ($isDocker) {
    $_ENV['PG_HOST'] = 'postgresql'; // Docker service name
    $_ENV['PG_PORT'] = '5432';       // internal port
    $_ENV['MONGO_URI'] = 'mongodb://mongodb:27017'; // optional
} else {
    $_ENV['PG_HOST'] = $_ENV['PG_HOST'] ?? 'host.docker.internal';
    $_ENV['PG_PORT'] = $_ENV['PG_PORT'] ?? '5555';
}
