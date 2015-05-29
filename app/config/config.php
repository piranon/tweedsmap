<?php
$config['mongo'] = array(
    'server' => 'mongodb://localhost:27017',
    'options' => array(
        'username' => 'dev1234', 'password' => 'mongotweets', 'db' => 'tweetsmap'
    )
);
$config['twitterOAuth'] = array(
    'oauth_access_token' => "96043352-pIki4d4LxCImNlZimURfHcVWgXvzSAUH97xY3erwv",
    'oauth_access_token_secret' => "MKKfNtqpoM8p43Oo7z1OXg1SjZ2glUMmNurU75eLl1Jst",
    'consumer_key' => "hRoUJpS5ikeqzBCc1d6B7heSd",
    'consumer_secret' => "VipO8YdZbloULB0ISlDeFuQR2Fb6IKlgPDmjWxQS1b8Kch62J2"
);
$config['searchUrl'] = 'https://api.twitter.com/1.1/search/tweets.json';
$config['searchLimit'] = 30;
$config['searchRadius'] = '50km';
