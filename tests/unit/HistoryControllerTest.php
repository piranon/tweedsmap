<?php

class HistoryControllerTest extends BaseUnitTest
{
    private $historyController;
    private $mockView;
    private $mockCookiesLibrary;

    protected function setUp()
    {
        parent::setUp();
        $this->historyController = new HistoryController();
        $this->mockView = $this->getMockBuilder('Phalcon\Mvc\View\Simple')->getMock();
        $this->mockCookiesLibrary = $this->getMockBuilder('CookiesLibrary')->getMock();
        $this->di->set('view', $this->mockView);
        $this->di->set('cookiesLibrary', $this->mockCookiesLibrary);
        $this->historyController->setDI($this->di);
    }

    protected function tearDown()
    {
    }

    public function testHistoryGetCookieAndCallView()
    {
        $this->mockCookiesLibrary->expects($this->once())->method('setCookie');
        $this->mockCookiesLibrary->expects($this->once())->method('get');
        $this->mockView->expects($this->once())->method('render');
        $this->historyController->indexAction();
    }
}
