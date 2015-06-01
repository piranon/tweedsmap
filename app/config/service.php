<?php
/**
 * Service
 *
 * This is a variant of the standard Phalcon\DI.
 * It automatically registers all the services provided by the framework.
 * Represents individually a service in the services container
 *
 *
 */
use Phalcon\Mvc\View\Simple as SimpleView;
use Phalcon\Mvc\View\Engine\Volt as Volt;
use Phalcon\Http\Response\Cookies as Cookies;
use Phalcon\Mvc\Router;

$di->set('request', 'Phalcon\Http\Request', true);
$di->set('response', 'Phalcon\Http\Response', true);
$di->set('tweetsLibrary', 'TweetsLibrary', true);
$di->set('cookiesLibrary', 'CookiesLibrary', true);

$di->set('config', function () {
    include '../app/config/config.php';
    $configObject = new \Phalcon\Config($config);
    return $configObject;
}, true);

$di->set('twitterAPIExchange', function () use ($di) {
    $twitterOAuth = (array) $di->get('config')->twitterOAuth;
    $twitterAPIExchange = new TwitterAPIExchange($twitterOAuth);
    return $twitterAPIExchange;
}, true);

$di->set('volt', function ($view, $di) {
    $volt = new Volt($view, $di);
    $volt->setOptions(array(
        "compiledPath" => "../app/views/compiled/",
        "compiledExtension" => ".compiled"
    ));
    return $volt;
}, true);

$di->set('view', function () {
    $view = new SimpleView();
    $view->setViewsDir('../app/views/');
    $view->registerEngines(array(
        ".phtml" => 'volt'
    ));
    return $view;
}, true);

$di->set('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
}, true);

$di->set('mongo', function () use ($di) {
    $config = $di->get('config')->mongo;
    $client = new MongoClient($config->server, (array) $config->options);
    $db = $client->{$config->options->db};
    return $db;
}, true);

$di->set('tweetsModel', function () use ($di) {
    $model = new TweetsModel();
    $model->setMongo($di->get('mongo'));
    return $model;
}, true);
