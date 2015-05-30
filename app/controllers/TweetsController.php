<?php

class TweetsController extends \Phalcon\Mvc\Controller {

	public function getTweetsAction()
	{
	    $options = array();
	    $options['city'] = $this->request->getPost('city');
	    $options['lat'] = $this->request->getPost('lat');
	    $options['lng'] = $this->request->getPost('lng');
        $tweets = $this->tweetsModel->get($options['city']);
        if (empty($tweets)) {
            $this->tweetsLibrary->setConfig($this->config);
            $this->tweetsLibrary->setTwitterAPIExchange($this->twitterAPIExchange);
            $tweets = $this->tweetsLibrary->getTweets($options);
            $cacheTime = $this->config->searchCacheTime;
            $this->tweetsModel->save($options['city'], $tweets, $cacheTime);
        }
        $this->response->setContentType('application/json');
        $this->response->setJsonContent($tweets);
	}
}
