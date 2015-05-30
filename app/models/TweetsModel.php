<?php

class TweetsModel
{
    private $mongo;

    public function setMongo(MongoDB $mongo)
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
        $cacheData = $collection->findOne($where);
        if (!empty($cacheData['tweets'])) {
            $tweets = $cacheData['tweets'];
        }
        return $tweets;
    }

    public function save($city, $tweets, $cacteTime)
    {
        $expireAt = $this->calculateExpireAt($cacteTime);
        $expireAt = $this->convertIsoDateToMongoDate($expireAt);
        $tweetsCache = array(
            'city' => (string) $city, 'expireAt' => $expireAt, 'tweets' => $tweets
        );
        $collection = $this->mongo->selectCollection('tweets');
        $collection->insert($tweetsCache);
    }

    private function calculateExpireAt($cacteTime)
    {
        $dateTime = date('Y-m-d H:i:s');
        $dateTimeInSec = strtotime($dateTime);
        $expireAt = $dateTimeInSec + $cacteTime;
        return date('Y-m-d H:i:s', $expireAt);
    }

    private function convertIsoDateToMongoDate($dateTime)
    {
        return new MongoDate(strtotime($dateTime));
    }
}
