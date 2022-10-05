<?php
declare(strict_types=1);

namespace App\View;

class View
{
    function generate($template, $data = null)
    {
        include dirname(__FILE__) ."/".$template;
    }
}