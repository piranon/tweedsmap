<?php

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->title = 'Tweets Map';
        echo $this->view->render('index');
    }
}
