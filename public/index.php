<?php

declare(strict_types=1);

use Laminas\Mvc\Application;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Loader\StandardAutoloader;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (is_string($path) && __FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run laminas composer install` if you are using Docker.\n"
    );
}

// This example assumes the StandardAutoloader is autoloadable.
$loader = new StandardAutoloader();
// Register the "Phly" namespace:
$loader->registerNamespace('Db', __DIR__ . '/../module/Application/src/Entity');
$loader->register();

define('AMBIENTE_PRODUCAO', 'producao');
define('AMBIENTE_DEVELOPER', 'developer');

if(@$_SERVER['SERVER_ADDR'] !== '10.10.50.41'){
    define('AMBIENTE_EXEC', AMBIENTE_DEVELOPER);
}else{
    define('AMBIENTE_EXEC', AMBIENTE_PRODUCAO);
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();
