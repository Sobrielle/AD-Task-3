<?php
    define('HANDLER_PATH', __DIR__ . '/handlers');

    require_once __DIR__ . '/envSetter.util.php'; // Load ENV first
    include_once HANDLER_PATH . '/mongodbChecker.handler.php';
    include_once HANDLER_PATH . '/postgreChecker.handler.php';
?>