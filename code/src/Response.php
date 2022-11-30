<?php
namespace Ppro\Hw5;

class Response
{
    private string $content;

    public function __construct(string $content = "")
    {
        $this->content = $content;
    }

    /** Установка заголовка ответа
     * @param bool $status
     * @return void
     */
    public function setHeader(bool $status): void
    {
        header($status ? "HTTP/1.1 200 OK" : "HTTP/1.1 400 Bad Request");
    }

    /** Установка содержимого ответа
     * @param string $string
     * @return void
     */
    public function setContent(string $string): void
    {
        $this->content .= $string."\r\n";
    }

    /** Получение содержимого ответа
     * @return string
     */
    public function getContent():string
    {
        return $this->content;
    }
}