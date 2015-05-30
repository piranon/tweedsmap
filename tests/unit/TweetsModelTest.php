<?php

class TweetsModelTest extends BaseUnitTest
{
    private $tweetsModel;
    private $mockMongo;
    private $mockMongoCollection;
    private $mockMongoCursor;

    protected function setUp()
    {
        parent::setUp();
        $this->mockMongo = $this->getMockBuilder('MongoDB')->disableOriginalConstructor()->getMock();
        $this->mockMongoCollection = $this->getMockBuilder('MongoCollection')->disableOriginalConstructor()->getMock();
        $this->mockMongoCursor = $this->getMockBuilder('MongoCursor')->disableOriginalConstructor()->getMock();
        $this->tweetsModel = new TweetsModel();
        $this->tweetsModel->setMongo($this->mockMongo);
    }

    protected function tearDown()
    {
    }

    public function testSaveTweetsCache()
    {
        $dateTime = date('Y-m-d H:i:s');
        $cacteTime = $this->di->get('config')->searchCacheTime;
        $cacteTimeInSec = strtotime($dateTime);
        $cacheDate = $cacteTimeInSec + $cacteTime;
        $expireAt =  date('Y-m-d H:i:s', $cacheDate);
        $tweets = array(
            array(
                'text' => 'ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs',
                'createdAt' => '2015-05-29 12:11:21', 'userName' => 'เสกไม่โอเค',
                'userProfileImageUrl' => 'http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg',
                'lat' => 13.75274551, 'lng' => 100.49402475
            )
        );
        $tweetsCache = array(
            'city' => 'กรุงเทพมหานคร', 'expireAt' => new MongoDate(strtotime($expireAt)),
            'tweets' => $tweets
        );
        $this->mockMongo->expects($this->once())->method('selectCollection')->with('tweets')->will($this->returnValue($this->mockMongoCollection));
        $this->mockMongoCollection->expects($this->once())->method('insert')->with($tweetsCache)->will($this->returnValue($this->mockMongoCollection));
        $this->tweetsModel->save('กรุงเทพมหานคร', $tweets, $cacteTime);
    }

    public function testGetTweetsCache()
    {
        $expected = array(
            array(
                'text' => 'ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs',
                'createdAt' => '2015-05-29 12:11:21', 'userName' => 'เสกไม่โอเค',
                'userProfileImageUrl' => 'http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg',
                'lat' => 13.75274551, 'lng' => 100.49402475
            )
        );
        $tweetsCache = array(
            'city' => 'กรุงเทพมหานคร', 'expireAt' => new MongoDate(strtotime('2015-05-30 02:42:00')),
            'tweets' => $expected
        );
        $where = array(
            'city' => 'กรุงเทพมหานคร'
        );
        $this->mockMongo->expects($this->once())->method('selectCollection')->with('tweets')->will($this->returnValue($this->mockMongoCollection));
        $this->mockMongoCollection->expects($this->once())->method('findOne')->with($where)->will($this->returnValue($tweetsCache));
        $tweets = $this->tweetsModel->get('กรุงเทพมหานคร');
        $this->assertEquals($expected, $tweets);
    }
}
