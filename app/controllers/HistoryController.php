<?php

class HistoryController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->cookiesLibrary->setCookie($this->cookies);
        $histories = $this->cookiesLibrary->get();
        $this->view->histories = $histories;
        $this->view->baseUrl = $this->config->baseUrl;
        $this->view->cssUrl = $this->config->cssUrl;
        $this->view->jsUrl = $this->config->jsUrl;
        $this->view->diUrl = $this->config->diUrl;
        echo $this->view->render('history');
    }
}
