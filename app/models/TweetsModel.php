<?php

class TweetsModel {

    private $mongo;

    public function setMongo(MongoClient $mongo)
    {
        $this->mongo = $mongo;
    }

    public function get($city)
    {
        $tweets = array();
        $where = array(
            'city' => (string) $city
        );
        $collection = $this->mongo->selectCollection('tweets');
        $cursor = $collection->find($where);
        $cacheData = $this->iteratorToArray($cursor);
        if (!empty($cacheData['tweets'])) {
            $tweets = $cacheData['tweets'];
        }
        return $tweets;
    }

	public function save($city, $tweets)
	{
	    $expireAt = $this->convertIsoDateToMongoDate(date('Y-m-d H:i:s'));
        $tweetsCache = array(
            'city' => (string) $city, 'expireAt' => $expireAt, 'tweets' => $tweets
        );
        $collection = $this->mongo->selectCollection('tweets');
        $collection->insert($tweetsCache);
	}

	private function convertIsoDateToMongoDate($dateTime)
	{
	    return new MongoDate(strtotime($dateTime));
	}

	public function iteratorToArray($cursor)
	{
	    $cursor = iterator_to_array($cursor);
	    return array_values($cursor);
	}
}