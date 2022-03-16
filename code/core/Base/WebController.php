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

    public function __construct()
    {
        $this->request = new Request();
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