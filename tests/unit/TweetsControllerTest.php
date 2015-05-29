<?php

class TweetsControllerTest extends BaseUnitTest
{
    private $tweetsController;
    private $mockRequest;
    private $mockResponse;
    private $mockTweetsLibrary;
    private $mockTwitterAPIExchange;

    protected function setUp()
    {
        parent::setUp();
        $this->tweetsController = new TweetsController();
        $this->mockRequest = $this->getMockBuilder('\Phalcon\Http\Request')->disableOriginalConstructor()->getMock();
        $this->mockResponse = $this->getMockBuilder('\Phalcon\Http\Response')->disableOriginalConstructor()->getMock();
        $this->mockTweetsLibrary = $this->getMockBuilder('TweetsLibrary')->disableOriginalConstructor()->getMock();
        $this->mockTwitterAPIExchange = $this->getMockBuilder('TwitterAPIExchange')->disableOriginalConstructor()->getMock();
        $this->di->set('request', $this->mockRequest);
        $this->di->set('response', $this->mockResponse);
        $this->di->set('tweetsLibrary', $this->mockTweetsLibrary);
        $this->di->set('twitterAPIExchange', $this->mockTwitterAPIExchange);
    }

    protected function tearDown()
    {
    }

    public function testGetTweetFromTwitterAPI()
    {
        $this->mockRequest->expects($this->at(0))->method('city');
        $this->mockRequest->expects($this->at(1))->method('lat');
        $this->mockRequest->expects($this->at(2))->method('lng');
        $this->mockTweetsLibrary->expects($this->once())->method('setConfig');
        $this->mockTweetsLibrary->expects($this->once())->method('setTwitterAPIExchange');
        $this->mockTweetsLibrary->expects($this->once())->method('getTweets');
        $this->mockResponse->expects($this->once())->method('setJsonContent');
        $this->mockResponse->expects($this->once())->method('setContentType')->with('application/json');
        $this->tweetsController->getTweetsAction();
    }
}
