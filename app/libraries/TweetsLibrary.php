<?php

class TweetsLibrary {

    private $twitterAPIExchange;

    public function setTwitterAPIExchange(TwitterAPIExchange $twitterAPIExchange)
    {
        $this->twitterAPIExchange = $twitterAPIExchange;
    }

    public function getTweets()
    {
        $getfield = '?q=กรุงเทพมหานคร&result_type=recent&count=30&geocode=13.7563309,100.50176510000006,50km';
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $jsonData = $this->twitterAPIExchange->setGetfield($getfield)->buildOauth($url, 'GET')->performRequest();
        $twitterAPIData = json_decode($jsonData, true);
        $tweets = array();
        foreach ($twitterAPIData['statuses'] as $data) {
            $tweet = array();
            $tweet['text'] = $data['text'];
            $tweet['createdAt'] = date( 'Y-m-d H:i:s', strtotime(str_replace('+0000', '', $data['created_at'])));
            $tweet['userName'] = $data['user']['name'];
            $tweet['userProfileImageUrl'] = $data['user']['profile_image_url'];
            $tweet['lat'] = $data['coordinates']['coordinates'][1];
            $tweet['lng'] = $data['coordinates']['coordinates'][0];
            $tweets[] = $tweet;
        }
        return $tweets;
    }
}