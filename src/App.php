<?php
declare(strict_types=1);
namespace Roman\Hw5;

class App
{
    private ?Router $router=null;

    public function __construct(){
        $this->router=new Router();
    }

    public function run(): void
    {
        var_dump($this->router);
        if(!is_null($this->router)){
            $this->router->run();
        }
    }

}