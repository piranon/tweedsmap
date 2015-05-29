<?php

class TweetsModel {

    private $mongo;

    public function setMongo(MongoClient $mongo)
    {
        $this->mongo = $mongo;
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
}