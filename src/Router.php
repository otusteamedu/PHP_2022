<?php
declare(strict_types=1);
namespace Roman\Hw5;

class Router
{
    private $uri;

    public function __construct(){
        if(isset($_SERVER['REQUEST_URI'])){
            $this->uri=trim($_SERVER['REQUEST_URI']);
        }
    }

    public function run(): void
    {
        var_dump($this->uri);

//        $view=new View('layouts/form.php');
//        $email=new Email();
//        echo $view->show($email->check_email());
    }

}