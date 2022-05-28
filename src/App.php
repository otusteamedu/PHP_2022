<?php

namespace Roman\Hw5;

class App
{

    public function run(): void
    {
        $view=new View('layouts/form.php');
        $email=new Email();
        echo $view->show($email->check_email());
    }

}