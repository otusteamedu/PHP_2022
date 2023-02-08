<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Request;

use Nikcrazy37\Hw12\Exception\EmptyParamException;
use Nikcrazy37\Hw12\Exception\EmptyRequestException;

class Request
{
    /**
     * @var array|false|null
     */
    private array|null|false $storage;

    /**
     * @throws EmptyRequestException
     */
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->storage = filter_input_array(INPUT_POST);

            if (empty($this->storage)) {
                throw new EmptyRequestException();
            }
        }
    }

    /**
     * @param $name
     * @return mixed
     * @throws EmptyParamException
     */
    public function __get($name)
    {
        if (empty($this->storage[$name])) {
            throw new EmptyParamException($name);
        }

        return $this->storage[$name];
    }

    /**
     * @return bool|array|null
     */
    public function getRequest(): bool|array|null
    {
        return $this->storage;
    }

    /**
     * @param $name
     * @return bool
     */
    public function exist($name): bool
    {
        if (empty($this->storage[$name])) {
            return false;
        }

        return true;
    }
}