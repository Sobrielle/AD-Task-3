<?php
    require_once 'bootstrap.php';
    require_once 'vendor/autoload.php';

    include_once UTILS_PATH . '/envSetter.util.php'; // Load ENV first
    include_once HANDLER_PATH . '/mongodbChecker.handler.php';
    include_once HANDLER_PATH . '/postgreChecker.handler.php';
?>