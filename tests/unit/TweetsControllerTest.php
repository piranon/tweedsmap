<?php

class TweetsControllerTest extends BaseUnitTest
{
    private $tweetsController;
    private $mockResponse;
    private $mockTweetsLibrary;
    private $mockTwitterAPIExchange;

    protected function setUp()
    {
        parent::setUp();
        $this->tweetsController = new TweetsController();
        $this->mockResponse = $this->getMockBuilder('\Phalcon\Http\Response')->disableOriginalConstructor()->getMock();
        $this->mockTweetsLibrary = $this->getMockBuilder('TweetsLibrary')->disableOriginalConstructor()->getMock();
        $this->mockTwitterAPIExchange = $this->getMockBuilder('TwitterAPIExchange')->disableOriginalConstructor()->getMock();
        $this->di->set('response', $this->mockResponse);
        $this->di->set('tweetsLibrary', $this->mockTweetsLibrary);
        $this->di->set('twitterAPIExchange', $this->mockTwitterAPIExchange);
    }

    protected function tearDown()
    {
    }

    public function testGetTweetsReturnJsonSuccess()
    {
        $this->mockTweetsLibrary->expects($this->once())->method('setConfig');
        $this->mockTweetsLibrary->expects($this->once())->method('setTwitterAPIExchange');
        $this->mockTweetsLibrary->expects($this->once())->method('getTweets');
        $this->mockResponse->expects($this->once())->method('setJsonContent');
        $this->mockResponse->expects($this->once())->method('setContentType')->with('application/json');
        $this->tweetsController->getTweetsAction();
    }
}
