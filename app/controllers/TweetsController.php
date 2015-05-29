<?php

class TweetsController extends \Phalcon\Mvc\Controller {

	public function getTweetsAction()
	{
	    $tweets = $this->tweetsLibrary->getTweets();
	    $this->response->setContentType('application/json');
	    $this->response->setJsonContent($tweets);
	}
}