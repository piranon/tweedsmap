<?php

abstract class BaseUnitTest extends \PHPUnit_Framework_TestCase {

	protected $di;

	protected function setUp()
	{
		$di = new \Phalcon\DI\FactoryDefault();
		include 'app/config/service.php';
		$this->di = $di;
	}
}