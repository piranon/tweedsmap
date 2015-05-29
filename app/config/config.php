<?php
$config['mongo'] = array(
    'server' => 'mongodb://localhost:27017',
    'options' => array(
        'username' => 'dev1234', 'password' => 'mongotweets', 'db' => 'tweetsmap'
    )
);
$config['searchUrl'] = 'https://api.twitter.com/1.1/search/tweets.json';
$config['searchLimit'] = 30;
$config['searchRadius'] = '50km';