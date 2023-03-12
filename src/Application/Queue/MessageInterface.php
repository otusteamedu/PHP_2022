<?php

namespace App\Application\Queue;

interface MessageInterface
{
    public function getBody(): string;
}