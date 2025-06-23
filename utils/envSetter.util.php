<?php

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$typeConfig = [
    'env_name' => $_ENV['ENV_calalay'] ?? 'local',

    'pg_host' => $_ENV['PG_HOST'],
    'pg_port' => $_ENV['PG_PORT'],
    'pg_db' => $_ENV['PG_DB'],
    'pg_user' => $_ENV['PG_USER'],
    'pg_pass' => $_ENV['PG_PASS'],

    'mongo_uri' => $_ENV['MONGO_URI'],
    'mongo_db' => $_ENV['MONGO_DB'],
];
