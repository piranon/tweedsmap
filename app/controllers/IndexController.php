<?php

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->baseUrl = $this->config->baseUrl;
        $this->view->cssUrl = $this->config->cssUrl;
        $this->view->jsUrl = $this->config->jsUrl;
        $this->view->diUrl = $this->config->diUrl;
        echo $this->view->render('index');
    }
}
