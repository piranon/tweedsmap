<?php

class IndexControllerTest extends BaseUnitTest
{
    private $indexController;
    private $mockView;

    protected function setUp()
    {
        parent::setUp();
        $this->indexController = new IndexController();
        $this->mockView = $this->getMockBuilder('Phalcon\Mvc\View\Simple')->getMock();
        $this->di->set('view', $this->mockView);
        $this->indexController->setDI($this->di);
    }

    protected function tearDown()
    {
    }

    public function testIndexCallView()
    {
        $this->mockView->expects($this->once())->method('render');
        $this->indexController->indexAction();
    }
}
