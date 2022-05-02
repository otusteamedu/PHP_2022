<?php

declare(strict_types=1);

namespace Mselyatin\Project5\classes;

use Mselyatin\Project5\interfaces\ResponseInterface;

/**
 * @JSONResponse
 * @\Mselyatin\Project5\classes\JSONResponse
 * @author Михаил Селятин
 */
final class JSONResponse implements ResponseInterface
{
    /** @var array  */
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function addItem(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public function removeItem(string $key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    /**
     * @throws \JsonException
     */
    public function buildResponse(): string
    {
        return json_encode($this->items, JSON_THROW_ON_ERROR);
    }

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}