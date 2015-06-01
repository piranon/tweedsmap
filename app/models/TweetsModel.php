<?php
/**
 * TweetsModel is responsible for retrieve and insert, tweests data in mongodb.
 *
 */
class TweetsModel
{

    /**
     * @var MongoDB $mongo  An instance of MongoDB Class.
     */
    private $mongo;

    /**
     * Sets the MongoDB
     *
     * @param MongoDB $mongo    A connection manager for PHP and MongoDB.
     */
    public function setMongo(MongoDB $mongo)
    {
        $this->mongo = $mongo;
    }

    /**
     * Get the Tweets from mongo db with the name of city.
     *
     * @param string $city  Location given by the user.
     * @return array    Collection of relevant Tweets matching a specified query.
     */
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

    /**
     * Store Collection of relevant Tweets specified by Location.
     *
     * @param string $city  Location given by the user.
     * @param array $tweets  Collection of relevant Tweets.
     * @param int $cacteTime  cache time in second.
     */
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

    /**
     * Calculate expire date of tweets data.
     *
     * @param string $cacteTime     cache time in second.
     * @return string    expire date in php date format.
     */
    private function calculateExpireAt($cacteTime)
    {
        $dateTime = date('Y-m-d H:i:s');
        $dateTimeInSec = strtotime($dateTime);
        $expireAt = $dateTimeInSec + $cacteTime;
        return date('Y-m-d H:i:s', $expireAt);
    }

    /**
     * Convert ISO date to MongoDate object.
     *
     * @param string $dateTime  php date format.
     * @return string   MongoDate object.
     */
    private function convertIsoDateToMongoDate($dateTime)
    {
        return new MongoDate(strtotime($dateTime));
    }
}
