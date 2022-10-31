<?php
declare(strict_types=1);

namespace Application\Contracts;

interface PrinterInterface
{
    public function out(array $books) : void;
}