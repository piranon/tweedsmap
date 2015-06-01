<?php
/**
 * IndexController is responsible for processing the incoming requests from the web browser
 * Provide html search form, Map to show the location searched for and to place tweets on
 *
 */
class IndexController extends \Phalcon\Mvc\Controller
{
    /**
     * The landing page for the user and where they will perform their searches
     *
     * URL: /
     */
    public function indexAction()
    {
        $this->view->title = 'Tweets Map';
        echo $this->view->render('index');
    }
}
