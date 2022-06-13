<?php
declare(strict_types=1);

namespace Roman\Hw5\Controllers;

use Roman\Hw5\Email;
use Roman\Hw5\View;

class EmailController extends Controller
{

    public function __construct(){
        $this->layout='layouts/form.php';
        $email = new Email();
        $this->data=$email->check_email();
    }

}