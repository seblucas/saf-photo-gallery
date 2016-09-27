<?php
define('SILEX_ROOT', dirname(__FILE__) . '/../');
define('SILEX_APP_ROOT', SILEX_ROOT . '/app/');
define('SILEX_SRC_ROOT', SILEX_APP_ROOT . '/src/');

// Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Silex App
$app = new \Gallery\Application\Application(require SILEX_APP_ROOT . 'config.php');

$app->run();