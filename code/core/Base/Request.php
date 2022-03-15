<?php

namespace Core\Base;

use Core\Exceptions\InvalidArgumentException;

class Request
{
    /**
     * @var array
     */
    private array $storage;

    public function __construct()
    {
        $this->storage = $this->cleanRequests($_REQUEST);
    }

    /**
     * @param array $data
     * @return array
     */
    private function cleanRequests(array $data) :array
    {
        $clean = [];

        if (count($data)) {
            foreach ($data as $key => $value) {
                $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
            }
        }

        return $clean;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(string $name)
    {
        if (isset($this->storage[$name])) {
            return  $this->storage[$name];
        }

        throw new InvalidArgumentException("param {$name} is not exists in request");
    }

    /**
     * @return array
     */
    public function all() :array
    {
        return $this->storage;
    }
}