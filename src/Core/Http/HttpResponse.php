<?php

namespace Queen\App\Core\Http;

class HttpResponse
{

    private int $statusCode = 200;
    private string $content;
    private string $statusText = 'OK';
    private array $headers;

    private array $statusTexts = [
        200 => 'OK',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
    ];

    /**
     * @param $content
     *
     * @return void
     */
    public function setContent($content)
    {
        $this->content = (string)$content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setStatusCode($statusCode, $statusText = null)
    {
        if ($statusText === null
            && array_key_exists((int)$statusCode, $this->statusTexts)
        ) {
            $statusText = $this->statusTexts[$statusCode];
        }

        $this->statusCode = (int)$statusCode;
        $this->statusText = (string)$statusText;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = [
            (string) $value,
        ];
    }

    /**
     * @param $url
     * @param $content
     *
     * @return void
     */
    public function redirect($url, $code = 301,  $content = null)
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
        $this->setHeader('Location', $url);
        $this->setStatusCode($code);
        $this->setContent($content);
    }
}
