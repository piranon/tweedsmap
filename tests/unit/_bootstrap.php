<?php
define('ENVIRONMENT', 'development');
$loader = new Phalcon\Loader();
$loader->registerDirs(
    array(
        'app/controllers/',
        'app/models/',
        'app/libraries/'
    )
);
$loader->register();
