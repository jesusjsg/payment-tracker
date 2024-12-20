<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', true);
ini_set('display_errors', true);
ini_set('log_errors', true);
ini_set('error_log', '/var/www/html/payment-tracker/php-error.log');

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\App;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new App();