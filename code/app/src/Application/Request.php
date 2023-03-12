<?php

namespace Ppro\Hw27\App\Application;

class Request
{
    /**
     * @var $this |null
     */
    private static ?self $instance = null;
    /**
     * @var string
     */
    protected $path = "/";
    /**
     * @var array
     */
    protected array $feedback = [];
    /**
     * @var array
     */
    protected array $content = [];

    /**
     *
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return void
     */
    private function init()
    {
        $path = $_SERVER['REQUEST_URI'] ?: '/';
        $this->path = $_SERVER['QUERY_STRING'] ? explode('?', $path)[0] : $path;
    }

    /**
     * @return mixed
     */
    public function getDocumentRoot()
    {
        return ($_SERVER['DOCUMENT_ROOT']);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === "POST";
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getQuery(string $name)
    {
        return $_GET[$name] ?? null;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getPost(string $name)
    {
        return $_POST[$name] ?? null;
    }

    /**
     * @return array
     */
    public function getPostParams()
    {
        return $_POST;
    }

    /** Формирование контента для страницы
     * @param $msg
     * @return void
     */
    public function addFeedback($msg)
    {
        array_push($this->feedback, $msg);
    }

    /**
     * @return array
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param $separator
     * @return string
     */
    public function getFeedbackString($separator = "\n")
    {
        return implode($separator, $this->feedback);
    }

    /** Формирование контента для страницы
     * @param string $key
     * @param mixed $content
     * @return void
     */
    public function setContent(string $key, mixed $content)
    {
        $this->content[$key] = $content;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }


}