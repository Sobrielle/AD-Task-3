<?php

require_once 'utils/auth.util.php';

if (Auth::check()) {
    header('Location: /dashboard.php');
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #f0f4f8, #d9e2ec);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .login-container label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: 500;
        }

        .login-container input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        .login-container input:focus {
            border-color: #1d4ed8;
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #1d4ed8;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #1e40af;
        }

        .error {
            color: #dc2626;
            background: #fee2e2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
            <div class="error">Invalid username or password.</div>
        <?php endif; ?>

        <form method="POST" action="/handlers/login.handler.php">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
