<?php

class TweetsController extends \Phalcon\Mvc\Controller {

	public function getTweetsAction()
	{
	    $options = array();
	    $options['city'] = $this->request->getPost('city');
	    $options['lat'] = $this->request->getPost('lat');
	    $options['lng'] = $this->request->getPost('lng');
// 	    $options = array(
// 	        'city' => 'กรุงเทพมหานคร', 'lat' => '13.7563309', 'lng' => '100.50176510000006'
// 	    );
        $this->tweetsLibrary->setConfig($this->config);
        $this->tweetsLibrary->setTwitterAPIExchange($this->twitterAPIExchange);
        $tweets = $this->tweetsLibrary->getTweets($options);
        $this->response->setContentType('application/json');
        $this->response->setJsonContent($tweets);
	}
}
