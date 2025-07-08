<?php
require_once UTILS_PATH . '/auth.util.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (Auth::login($username, $password)) {
    header('Location: /dashboard.php');
    exit;
} else {
    header('Location: /login.php?error=invalid');
    exit;
}
