<?php

class TweetsController extends \Phalcon\Mvc\Controller {

	public function getTweetsAction()
	{
	    $options = array();
	    $options['city'] = $this->request->getPost('city');
	    $options['lat'] = $this->request->getPost('lat');
	    $options['lng'] = $this->request->getPost('lng');
        $this->tweetsLibrary->setConfig($this->config);
        $this->tweetsLibrary->setTwitterAPIExchange($this->twitterAPIExchange);
        $tweets = $this->tweetsLibrary->getTweets($options);
        $this->response->setContentType('application/json');
        $this->response->setJsonContent($tweets);
	}
}
