<?php

namespace Kopte\Code\Components;

class Request
{
    private array $get;
    private array $post;
    private array $server;

    /**
     * Request constructor
     */
    public function __construct()
    {
        $this->get = $this->cleanInput($_GET);
        $this->post = $this->cleanInput($_POST);
        $this->server = $this->cleanInput($_SERVER);
    }

    /**
     * Get one GET parameter or all GET parameters.
     *
     * @param string|null $name
     * @return array|mixed|string|null
     */
    public function get(?string $name)
    {
        return empty($name)
            ? $this->get
            : ($this->get[$name] ?? null);
    }

    /**
     * Get one POST parameter or all POST parameters.
     *
     * @param string|null $name
     * @return array|mixed|string|null
     */
    public function post(?string $name)
    {
        return empty($name)
            ? $this->post
            : ($this->post[$name] ?? null);
    }

    /**
     * Get one SERVER parameter or all POST parameters.
     *
     * @param string|null $name
     * @return array|mixed|string|null
     */
    public function server(?string $name)
    {
        return empty($name)
            ? $this->server
            : ($this->server[$name] ?? null);
    }

    /**
     * Clean input params.
     *
     * @param mixed $data
     * @return array|string
     */
    private function cleanInput($data)
    {
        if (is_array($data)) {
            $cleaned = [];

            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }

            return $cleaned;
        }

        return trim(htmlspecialchars($data, ENT_QUOTES));
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->server('REQUEST_METHOD');
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->server('REQUEST_URI');
    }
}
