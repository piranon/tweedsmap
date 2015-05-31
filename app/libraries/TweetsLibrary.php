<?php

class TweetsLibrary
{
    private $config;
    private $twitterAPIExchange;

    public function setConfig(\Phalcon\Config $config)
    {
        $this->config = $config;
    }

    public function setTwitterAPIExchange(TwitterAPIExchange $twitterAPIExchange)
    {
        $this->twitterAPIExchange = $twitterAPIExchange;
    }

    public function getTweets($options)
    {
        $searchFields = $this->createSearchFields($options);
        $twitterAPIData = $this->getDataFromAPI($searchFields);
        $tweets = $this->prepareDateTweets($twitterAPIData);
        return $tweets;
    }

    private function createSearchFields($options)
    {
        $city = $options['city'];
        $lat = $options['lat'];
        $lng = $options['lng'];
        $limit = $this->config->searchLimit;
        $radius = $this->config->searchRadius;
        $getfield = '?q=' . $city;
        $getfield .= '&result_type=mixed';
        $getfield .= '&count=' . $limit;
        $getfield .= '&geocode=' . $lat . ',' . $lng . ',' . $radius;
        return $getfield;
    }

    private function getDataFromAPI($searchFields)
    {
        $url = $this->config->searchUrl;
        $twitterAPI = $this->twitterAPIExchange->setGetfield($searchFields);
        $twitterAPI = $twitterAPI->buildOauth($url, 'GET');
        $jsonData = $twitterAPI->performRequest();
        return json_decode($jsonData, true);
    }

    private function prepareDateTweets($twitterAPIData)
    {
        $tweets = array();
        foreach ($twitterAPIData['statuses'] as $data) {
            $tweet = array();
            $tweet['text'] = $data['text'];
            $tweet['createdAt'] = $this->convertTwitterDate($data['created_at']);
            $tweet['userName'] = $data['user']['name'];
            $tweet['userProfileImageUrl'] = $data['user']['profile_image_url'];
            $tweet['lat'] = $data['coordinates']['coordinates'][1];
            $tweet['lng'] = $data['coordinates']['coordinates'][0];
            $tweets[] = $tweet;
        }
        return $tweets;
    }

    private function convertTwitterDate($date)
    {
        $date = str_replace('+0000', '', $date);
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
