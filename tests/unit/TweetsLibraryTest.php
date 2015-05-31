<?php

class TweetsLibraryTest extends BaseUnitTest
{
    private $tweetsLibrary;
    private $mockTwitterAPIExchange;

    protected function setUp()
    {
        parent::setUp();
        $this->tweetsLibrary = new TweetsLibrary();
        $this->mockTwitterAPIExchange = $this->getMockBuilder('TwitterAPIExchange')->disableOriginalConstructor()->getMock();
        $this->tweetsLibrary->setTwitterAPIExchange($this->mockTwitterAPIExchange);
        $this->tweetsLibrary->setConfig($this->di->get('config'));
    }

    protected function tearDown()
    {
    }

    public function testGetTweetsReturnArray()
    {
        $expected = array(
            array(
                'text' => 'ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs',
                'createdAt' => '2015-05-29 12:11:21', 'userName' => 'เสกไม่โอเค',
                'userProfileImageUrl' => 'http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg',
                'lat' => 13.75274551, 'lng' => 100.49402475
            )
        );
        $options = array(
            'city' => 'กรุงเทพมหานคร', 'lat' => '13.7563309', 'lng' => '100.50176510000006'
        );
        $getfield = '?q=กรุงเทพมหานคร&result_type=mixed&count=30&geocode=13.7563309,100.50176510000006,50km';
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $twitterAPIReturn = '{
                "statuses": [{
                        "created_at": "Fri May 29 12:11:21 +0000 2015",
                        "text": "ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs",
                        "user": {
                            "name": "เสกไม่โอเค",
                            "profile_image_url": "http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg"
                        },
                        "coordinates": {
                            "coordinates": [
                                100.49402475,
                                13.75274551
                            ]
                        }
                    }]
                }';
        $this->mockTwitterAPIExchange->expects($this->once())->method('setGetfield')->with($getfield)->will($this->returnValue($this->mockTwitterAPIExchange));
        $this->mockTwitterAPIExchange->expects($this->once())->method('buildOauth')->with($url, 'GET')->will($this->returnValue($this->mockTwitterAPIExchange));
        $this->mockTwitterAPIExchange->expects($this->once())->method('performRequest')->will($this->returnValue($twitterAPIReturn));
        $tweets = $this->tweetsLibrary->getTweets($options);
        $this->assertEquals($expected, $tweets);
    }
}
