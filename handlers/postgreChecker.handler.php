<?php
require_once __DIR__ . '/../envSetter.util.php';

$host = $_ENV['POSTGRES_HOST'];
$port = $_ENV['POSTGRES_PORT'];
$username = $_ENV['POSTGRES_USER'];
$password = $_ENV['POSTGRES_PASSWORD'];
$dbname = $_ENV['POSTGRES_DB'];

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: " . pg_last_error() . " <br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection <br>";
    pg_close($dbconn);
}
