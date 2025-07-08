<?php
declare(strict_types=1);

require_once UTILS_PATH . '/envSetter.util.php';

class Auth
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(string $username, string $password): bool
    {
        self::init();

        $connStr = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            $_ENV['PG_HOST'],
            $_ENV['PG_PORT'],
            $_ENV['PG_DB'],
            $_ENV['PG_USER'],
            $_ENV['PG_PASS']
        );

        $dbconn = pg_connect($connStr);

        if (!$dbconn) {
            return false;
        }

        $result = pg_query_params(
            $dbconn,
            "SELECT * FROM users WHERE username = $1 LIMIT 1;",
            [$username]
        );

        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            pg_close($dbconn);
            return true;
        }

        pg_close($dbconn);
        return false;
    }

    public static function user(): ?array
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }


    public static function check(): bool
    {
        self::init();
        return isset($_SESSION['user']);
    }


    public static function logout(): void
    {
        self::init();
        $_SESSION = [];
        session_destroy();
    }
}
