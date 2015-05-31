<?php

class HistoryController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->cookiesLibrary->setCookie($this->cookies);
        $histories = $this->cookiesLibrary->get();
        $this->view->title = 'History';
        $this->view->histories = $histories;
        echo $this->view->render('history');
    }
}
