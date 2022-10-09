<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\render;

interface OutputInterface
{
    public function echo(array $message): void;
}
