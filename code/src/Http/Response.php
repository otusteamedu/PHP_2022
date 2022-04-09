<?php

declare(strict_types=1);

namespace Ilia\Otus\Http;

/**
 * Класс Response.
 */
class Response {
    private $content;
    private $statusCode;
    private $headers;
    
    /**
     * Создает ответ сервера
     * 
     * @param integer $status_code                  HTTP-статус код ответа
     * @param array $headers                        HTTP-заголовки ответа
     */
    public function __construct($statusCode = 200, $headers = array()) {
        // устанавливаем свойства класса
        $this->status_code  = $statusCode;
        $this->headers      = $headers;
    }
    
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }
    
    public function setHeader($header) {
        $this->headers[] = $header;
    }

    public function setContent($content) {
        $this->content = $content;
    }
    
    public function send() {
        // выслать код статуса HTTP
        header('HTTP/1.1 ' . $this->status_code);
        
        // отправить заголовки HTTP
        foreach ( $this->headers as $header ){
            header($header);
        }
          
        
        // отправить содержимое ответа
        echo $this->content;
    }
}
?>