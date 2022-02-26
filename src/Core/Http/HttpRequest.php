<?php

namespace Queen\App\Core\Http;

class HttpRequest
{
    protected $getParameters;
    protected $postParameters;
    protected $server;

    public function __construct(
        array $get,
        array $post,
        array $server

    ) {
        $this->getParameters = $get;
        $this->postParameters = $post;
        $this->server = $server;
    }

    /**
     * @throws RequestException
     */
    public function getPath()
    {
        return strtok($this->getServerVariable('REQUEST_URI'), '?');
    }

    /**
     * @throws RequestException
     */
    public function getMethod()
    {
        return $this->getServerVariable('REQUEST_METHOD');
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return array_merge($this->getParameters, $this->postParameters);
    }

    public function getParameter($key, $defaultValue = null)
    {
        if (array_key_exists($key, $this->postParameters)) {
            return $this->postParameters[$key];
        }

        if (array_key_exists($key, $this->getParameters)) {
            return $this->getParameters[$key];
        }

        return $defaultValue;
    }

    /**
     * @throws RequestException
     */
    private function getServerVariable($key)
    {
        if (!array_key_exists($key, $this->server)) {
            throw new RequestException($key);
        }

        return $this->server[$key];
    }
}
