<?php

declare(strict_types=1);

namespace Mselyatin\Project5\interfaces;

/**
 * @RequestInterface
 * @\Mselyatin\Project5\interfaces\RequestInterface
 * @author Михаил Селятин
 */
interface RequestInterface
{
    /**
     * Возвращает POST данные
     * @param string|null $key
     * @return array|string
     */
    public function post(?string $key = null);

    /**
     * Возвращает GET данные
     * @param string|null $key
     * @return array|string
     */
    public function get(?string $key = null);
}