<?php
use Phalcon\Loader;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;

if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    define('ENVIRONMENT', 'development');
    error_reporting(E_ALL);
} else {
    define('ENVIRONMENT', 'production');
    error_reporting(0);
}

try {
    $loader = new Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/',
            '../app/libraries/'
        )
    );
    $loader->register();
    $di = new FactoryDefault();
    include '../app/config/service.php';
    include '../vendor/autoload.php';
    $application = new Application($di);
    $application->useImplicitView(false);
    echo $application->handle()->getContent();
} catch (Exception $e) {
     echo "Error: ", $e->getMessage();
}
