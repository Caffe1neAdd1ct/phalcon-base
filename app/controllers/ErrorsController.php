<?php
class ErrorsController extends Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $this->tag->setTitle('Oops!');
    }
    public function show404Action()
    {
        $this->response->setStatusCode('401', "Resource not found.");
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
        $this->response->setStatusCode('401', "Internal server error.");
    }
}