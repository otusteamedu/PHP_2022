<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\interfaces;

/**
 * @ResponseInterface
 * @\Mselyatin\Project6\src\interfaces\ResponseInterface
 */
interface ResponseInterface
{
    public function addItem($key, $item): void;
    public function removeItem($key): void;
    public function buildResponse();
}