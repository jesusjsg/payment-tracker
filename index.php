<?php

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', true);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', '/var/www/html/payment-tracker/php-error.log');
error_log('App init');

require_once 'libs/app.php';

$app = new App();