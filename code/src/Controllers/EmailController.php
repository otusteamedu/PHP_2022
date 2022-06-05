<?php
declare(strict_types=1);

namespace Roman\Hw5\Controllers;

use Roman\Hw5\Email;
use Roman\Hw5\View;

class EmailController
{
    private string $layout = 'layouts/form.php';

    public function run(): void
    {
        $view = new View($this->layout);
        $email = new Email();
        echo $view->show($email->check_email());
    }

}