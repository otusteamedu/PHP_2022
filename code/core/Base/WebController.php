<?php

namespace Core\Base;

class WebController
{
    /**
     * @var string $defaultAction
     * @var Request $request
     */
    protected string $defaultAction = 'index';
    protected Request $request;
    protected Response $response;
    protected Session $session;
    protected Validator $validator;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->validator = new Validator();
    }

    /**
     * @param null|string $name
     * @return void
     */
    public function runAction(string $name = null)
    {
        if(empty($name)){
           $this->{'action' . ucfirst($this->defaultAction)}();
        }else{
           $this->{'action' . ucfirst($name)}();
        }
    }
}