<?php

namespace Mselyatin\Queue\infrastructure\abstracts;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
abstract class ControllerAbstract
{
    /** @var Request  */
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request(
            $_GET,
            $_POST
        );
    }
}