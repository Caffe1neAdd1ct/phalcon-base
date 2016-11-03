<?php

class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Oops!');
        parent::initialize();
    }
    public function show404Action()
    {
        $this->response->setStatusCode('404', "Resource not found.");
    }
    
    public function show401Action()
    {
        $this->response->setStatusCode('401', "Authentication required to view this resource.");
    }
    
    public function show403Action()
    {
        $this->response->setStatusCode('403', "Authentication required to view this resource.");
    }
    
    public function show500Action()
    {
        $this->response->setStatusCode('500', "Internal server error.");
    }
}