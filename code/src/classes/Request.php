<?php

declare(strict_types=1);

namespace Mselyatin\Project5\classes;

use Mselyatin\Project5\interfaces\RequestInterface;

/**
 * @Request
 * @\Mselyatin\Project5\classes\Request
 * @author Михаил Селятин
 */
class Request implements RequestInterface
{
    /**
     * @param string|null $key
     * @return array|string
     */
    public function post(?string $key = null)
    {
        if (null !== $key) {
            return $_POST[$key] ?? null;
        }

        return $_POST ?? [];
    }

    /**
     * @param string|null $key
     * @return array|string
     */
    public function get(?string $key = null)
    {
        if (null !== $key) {
            return $_GET[$key] ?? null;
        }

        return $_GET ?? [];
    }
}