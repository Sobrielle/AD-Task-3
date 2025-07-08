<?php
require_once 'utils/auth.util.php';

if (!Auth::check()) {
    header('Location: /login.php');
    exit;
}

$user = Auth::user();
?>

<?php
require_once 'utils/auth.util.php';

// Protect this page
if (!Auth::check()) {
    header('Location: /login.php');
    exit;
}

$user = Auth::user();
?>

<h1>Welcome, <?= htmlspecialchars($user['full_name']) ?>!</h1>
<p>Your role is: <?= htmlspecialchars($user['role']) ?></p>

<a href="/handlers/logout.handler.php">Logout</a>
