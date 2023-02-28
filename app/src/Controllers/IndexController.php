<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Controllers;

class IndexController extends Controller
{
    public function index(): void
    {
        echo $this->render->render('../view/view.php');
    }
}
