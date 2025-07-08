<?php
require_once UTILS_PATH . '/auth.util.php';

Auth::logout();

header('Location: /login.php');
exit;


