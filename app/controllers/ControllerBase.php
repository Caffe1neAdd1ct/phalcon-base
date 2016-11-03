<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('Phalcon App | ');
        $this->view->setMainView('index');
        
        if($this->session->has('auth')) {
            
            $auth = $this->session->get('auth');
            $user = Users::findByUsernameFirst($auth['username']);
            
            $this->view->hasAuth = true;
            $this->view->user = $user;
            
        } else {
            $this->view->hasAuth = false;
        }
    }
    
    protected function loggedInRedirect()
    {
        if($this->session->has('auth')) {
            $this->response->redirect('overview');
            $this->view->disable();
            return true;
        }
    }
}
