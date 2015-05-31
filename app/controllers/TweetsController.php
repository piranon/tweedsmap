<?php

class TweetsController extends \Phalcon\Mvc\Controller
{
    public function getTweetsAction()
    {
        $param = array();
        $param['city'] = $this->request->getPost('city');
        $param['lat'] = $this->request->getPost('lat');
        $param['lng'] = $this->request->getPost('lng');
        $options = $this->validateParam($param);
        $tweets = $this->tweetsModel->get($options['city']);
        if (empty($tweets)) {
            $this->tweetsLibrary->setConfig($this->config);
            $this->tweetsLibrary->setTwitterAPIExchange($this->twitterAPIExchange);
            $tweets = $this->tweetsLibrary->getTweets($options);
            $cacheTime = $this->config->searchCacheTime;
            $this->tweetsModel->save($options['city'], $tweets, $cacheTime);
        }
        $this->cookiesLibrary->setCookie($this->cookies);
        $this->cookiesLibrary->save($options['city']);
        $this->response->setContentType('application/json');
        $this->response->setJsonContent($tweets);
    }

    public function validateParam($param)
    {
        $searchDefault = (array) $this->config->searchDefault;
        $param = array_filter($param);
        $options = array_merge($searchDefault, $param);
        $options = array_intersect_key($options, $searchDefault);
        return $options;
    }
}
