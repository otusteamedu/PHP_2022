<?php

namespace App\Application\Contracts;

interface ResponseInterface
{
    public function out(string $message);
}