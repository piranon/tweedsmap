<?php

class TweetsControllerTest extends BaseUnitTest
{
    private $tweetsController;
    private $mockResponse;
    private $mockTweetsLibrary;

    protected function setUp()
    {
        parent::setUp();
        $this->tweetsController = new TweetsController();
        $this->mockResponse = $this->getMockBuilder('\Phalcon\Http\Response')->disableOriginalConstructor()->getMock();
        $this->mockTweetsLibrary = $this->getMockBuilder('TweetsLibrary')->disableOriginalConstructor()->getMock();
        $this->di->set('response', $this->mockResponse);
        $this->di->set('tweetsLibrary', $this->mockTweetsLibrary);
    }

    protected function tearDown()
    {
    }

    public function testGetTweetsReturnJsonSuccess()
    {
        $this->mockResponse->expects($this->once())->method('setJsonContent');
        $this->mockResponse->expects($this->once())->method('setContentType')->with('application/json');
        $this->mockTweetsLibrary->expects($this->once())->method('getTweets');
        $this->tweetsController->getTweetsAction();
    }
}