<?php
/**
 * Phalcon\Config
 *
 * Phalcon\Config is configuration data within applications.
 * It provides a nested object property based user interface for accessing this configuration data within
 * application code.
 *
 *
 */
if (ENVIRONMENT == 'production') {
    $config['baseUrl'] = 'http://tweetsmap.tk/';
    $config['cssUrl'] = $config['baseUrl'] . 'css/';
    $config['jsUrl'] = $config['baseUrl'] . 'js/';
    $config['diUrl'] = $config['baseUrl'] . 'di/';
    $config['mongo'] = array(
        'server' => 'mongodb://localhost:27017',
        'options' => array(
            'db' => 'tweetsmap'
        )
    );
} else {
    $config['baseUrl'] = 'http://localhost/tweetsmap/';
    $config['cssUrl'] = $config['baseUrl'] . 'css/';
    $config['jsUrl'] = $config['baseUrl'] . 'js/';
    $config['diUrl'] = $config['baseUrl'] . 'di/';
    $config['mongo'] = array(
        'server' => 'mongodb://localhost:27017',
        'options' => array(
            'username' => 'dev1234', 'password' => 'dev1234', 'db' => 'tweetsmap'
        )
    );
}
$config['twitterOAuth'] = array(
    'oauth_access_token' => "96043352-pIki4d4LxCImNlZimURfHcVWgXvzSAUH97xY3erwv",
    'oauth_access_token_secret' => "MKKfNtqpoM8p43Oo7z1OXg1SjZ2glUMmNurU75eLl1Jst",
    'consumer_key' => "hRoUJpS5ikeqzBCc1d6B7heSd",
    'consumer_secret' => "VipO8YdZbloULB0ISlDeFuQR2Fb6IKlgPDmjWxQS1b8Kch62J2"
);
$config['searchDefault'] = array(
    'city' => 'กรุงเทพมหานคร', 'lat' => '13.7563309', 'lng' => '100.50176510000006'
);
$config['searchUrl'] = 'https://api.twitter.com/1.1/search/tweets.json';
$config['searchLimit'] = 30;
$config['searchRadius'] = '50km';
$config['searchCacheTime'] = 3600;
