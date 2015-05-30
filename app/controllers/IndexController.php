<?php

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->baseUrl = 'http://localhost/tweetsmap/';
        $this->view->cssUrl = 'http://localhost/tweetsmap/css/';
        $this->view->jsUrl = 'http://localhost/tweetsmap/js/';
        echo $this->view->render('index');
    }
}
