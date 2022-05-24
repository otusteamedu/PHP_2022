<?php
declare(strict_types=1);

namespace Shilyaev\Strings;

class Request
{
    public function getString() : string
    {
        if (isset($_POST['string']))
            return $_POST['string'];
        else
            throw new \Exception('Empty request.');
    }

}