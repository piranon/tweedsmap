<?php

abstract class BaseUnitTest extends \PHPUnit_Framework_TestCase {

	protected $di;

	protected function setUp()
	{
		$di = new \Phalcon\DI\FactoryDefault();
		$di->set('config', function() {
		    include 'app/config/config.php';
		    $configObject = new \Phalcon\Config($config);
		    return $configObject;
		}, true);
		$this->di = $di;
	}
}