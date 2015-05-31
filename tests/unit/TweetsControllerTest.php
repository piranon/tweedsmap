<?php

class TweetsControllerTest extends BaseUnitTest
{
    private $tweetsController;
    private $mockRequest;
    private $mockResponse;
    private $mockTweetsLibrary;
    private $mockCookiesLibrary;
    private $mockTweetsModel;
    private $mockTwitterAPIExchange;

    protected function setUp()
    {
        parent::setUp();
        $this->tweetsController = new TweetsController();
        $this->mockRequest = $this->getMockBuilder('\Phalcon\Http\Request')->getMock();
        $this->mockResponse = $this->getMockBuilder('\Phalcon\Http\Response')->getMock();
        $this->mockTweetsLibrary = $this->getMockBuilder('TweetsLibrary')->disableOriginalConstructor()->getMock();
        $this->mockCookiesLibrary = $this->getMockBuilder('CookiesLibrary')->disableOriginalConstructor()->getMock();
        $this->mockTweetsModel = $this->getMockBuilder('TweetsModel')->disableOriginalConstructor()->getMock();
        $this->mockTwitterAPIExchange = $this->getMockBuilder('TwitterAPIExchange')->disableOriginalConstructor()->getMock();
        $this->di->set('request', $this->mockRequest);
        $this->di->set('response', $this->mockResponse);
        $this->di->set('tweetsLibrary', $this->mockTweetsLibrary);
        $this->di->set('cookiesLibrary', $this->mockCookiesLibrary);
        $this->di->set('tweetsModel', $this->mockTweetsModel);
        $this->di->set('twitterAPIExchange', $this->mockTwitterAPIExchange);
        $this->tweetsController->setDI($this->di);

    }

    protected function tearDown()
    {
    }

    public function testGetTweetFromTwitterAPI()
    {
        $this->mockRequest->expects($this->at(1))->method('getPost')->with('city');
        $this->mockRequest->expects($this->at(2))->method('getPost')->with('lat');
        $this->mockRequest->expects($this->at(3))->method('getPost')->with('lng');
        $this->mockTweetsModel->expects($this->once())->method('get')->will($this->returnValue(false));
        $this->mockTweetsLibrary->expects($this->once())->method('setConfig');
        $this->mockTweetsLibrary->expects($this->once())->method('setTwitterAPIExchange');
        $this->mockTweetsLibrary->expects($this->once())->method('getTweets');
        $this->mockTweetsModel->expects($this->once())->method('save');
        $this->mockCookiesLibrary->expects($this->once())->method('setCookie');
        $this->mockCookiesLibrary->expects($this->once())->method('save');
        $this->mockResponse->expects($this->once())->method('setJsonContent');
        $this->mockResponse->expects($this->once())->method('setContentType')->with('application/json');
        $this->tweetsController->getTweetsAction();
    }

    public function testGetTweetFromTwitterCache()
    {
        $tweetsCache = array(
            array(
                'text' => 'ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs',
                'createdAt' => '2015-05-29 12:11:21', 'userName' => 'เสกไม่โอเค',
                'userProfileImageUrl' => 'http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg',
                'lat' => 13.75274551, 'lng' => 100.49402475
            )
        );
        $this->mockRequest->expects($this->at(1))->method('getPost')->with('city');
        $this->mockRequest->expects($this->at(2))->method('getPost')->with('lat');
        $this->mockRequest->expects($this->at(3))->method('getPost')->with('lng');
        $this->mockTweetsModel->expects($this->once())->method('get')->will($this->returnValue($tweetsCache));
        $this->mockTweetsLibrary->expects($this->never())->method('setConfig');
        $this->mockTweetsLibrary->expects($this->never())->method('setTwitterAPIExchange');
        $this->mockTweetsLibrary->expects($this->never())->method('getTweets');
        $this->mockTweetsModel->expects($this->never())->method('save');
        $this->mockCookiesLibrary->expects($this->once())->method('setCookie');
        $this->mockCookiesLibrary->expects($this->once())->method('save');
        $this->mockResponse->expects($this->once())->method('setJsonContent');
        $this->mockResponse->expects($this->once())->method('setContentType')->with('application/json');
        $ttt = $this->tweetsController->getTweetsAction();
    }

    public function testValidateParamEmtyAllValues()
    {
        $expected = array(
            'city' => 'กรุงเทพมหานคร', 'lat' => '13.7563309', 'lng' => '100.50176510000006'
        );
        $param = array();
        $options = $this->tweetsController->validateParam($param);
        $this->assertEquals($expected, $options);
    }

    public function testValidateParamWithExceedField()
    {
        $expected = array(
            'city' => 'นครสวรรค์', 'lat' => '15.6213959', 'lng' => '99.9599927'
        );
        $param = array(
            'city' => 'นครสวรรค์', 'lat' => '15.6213959', 'lng' => '99.9599927',
            'wrongField' => '121212'
        );
        $options = $this->tweetsController->validateParam($param);
        $this->assertEquals($expected, $options);
    }
}
