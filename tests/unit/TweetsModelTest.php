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
        $this->mockMongo = $this->getMockBuilder('MongoClient')->disableOriginalConstructor()->getMock();
        $this->mockMongoCollection = $this->getMockBuilder('MongoCollection')->disableOriginalConstructor()->getMock();
        $this->mockMongoCursor = $this->getMockBuilder('MongoCursor')->disableOriginalConstructor()->getMock();
        $method = array(
            'iteratorToArray'
        );
        $this->tweetsModel = $this->getMock('TweetsModel', $method);
        $this->tweetsModel->setMongo($this->mockMongo);
    }

    protected function tearDown()
    {
    }

    public function testSaveTweetsCache()
    {
        $dateTime = date('Y-m-d H:i:s');
        $tweets = array(
            array(
                'text' => 'ร้อน (@ กรุงเทพมหานคร (Bangkok) in Bangkok, Thailand) https://t.co/boganjD9cs',
                'createdAt' => '2015-05-29 12:11:21', 'userName' => 'เสกไม่โอเค',
                'userProfileImageUrl' => 'http://pbs.twimg.com/profile_images/603604862765387776/cADbF-Ih_normal.jpg',
                'lat' => 13.75274551, 'lng' => 100.49402475
            )
        );
        $tweetsCache = array(
            'city' => 'กรุงเทพมหานคร', 'expireAt' => new MongoDate(strtotime($dateTime)),
            'tweets' => $tweets
        );
        $this->mockMongo->expects($this->once())->method('selectCollection')->with('tweets')->will($this->returnValue($this->mockMongoCollection));
        $this->mockMongoCollection->expects($this->once())->method('insert')->with($tweetsCache)->will($this->returnValue($this->mockMongoCollection));
        $this->tweetsModel->save('กรุงเทพมหานคร', $tweets);
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
        $this->mockMongoCollection->expects($this->once())->method('find')->with($where)->will($this->returnValue($this->mockMongoCursor));
        $this->tweetsModel->expects($this->once())->method('iteratorToArray')->will($this->returnValue($tweetsCache));
        $tweets = $this->tweetsModel->get('กรุงเทพมหานคร');
        $this->assertEquals($expected, $tweets);
    }
}
