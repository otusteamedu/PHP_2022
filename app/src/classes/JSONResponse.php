<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\classes;

use Mselyatin\Project6\src\interfaces\ResponseInterface;

/**
 * @JSONResponse
 * @\Mselyatin\Project6\src\classes\JSONResponse
 */
class JSONResponse implements ResponseInterface
{
    /** @var array  */
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem($key, $item): void
    {
       $this->items[$key] = $item;
    }

    public function removeItem($key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @throws \JsonException
     */
    public function buildResponse(): string
    {
        return json_encode($this->items, JSON_THROW_ON_ERROR);
    }
}