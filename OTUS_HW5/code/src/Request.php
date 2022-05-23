<?php
declare(strict_types=1);

namespace PShilyaev;

class Request
{
    public function getString() : string
    {
        if (isset($_POST['string']) && strlen(trim($_POST['string']))>0)
            return trim($_POST['string']);
        else
            throw new \Exception('Bad Request');
    }

}