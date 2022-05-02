<?php

declare(strict_types=1);

namespace Mselyatin\Project5\interfaces;

/**
 * @ResponseInterface
 * @\Mselyatin\Project5\interfaces\ResponseInterface
 * @author Михаил Селятин
 */
interface ResponseInterface
{
    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function addItem(string $key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function removeItem(string $key);

    /**
     * @return mixed
     */
    public function buildResponse();

    /**
     * Установить код ответа HTTP
     * @param int $code
     */
    public function setStatusCode(int $code): void;
}