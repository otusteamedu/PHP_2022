<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Http;

class Response
{
    /**
     * Коды ответа
     */
    public const CODE_SUCCESS = 200;
    public const CODE_ERROR = 400;
    public const CODE_404 = 404;

    /**
     * Текст кода
     */
    public const CODE_TEXT = [
        self::CODE_SUCCESS => 'OK',
        self::CODE_ERROR => 'Bad Request',
        self::CODE_404 => 'Not Found'
    ];

    /**
     * Статусы ответа
     */
    private const STATUS_ERROR = 'danger';
    private const STATUS_SUCCESS = 'success';

    /**
     * @var int Код ответа
     */
    private int $code;

    /**
     * @var string Статус ответа
     */
    private string $status;

    /**
     * Constructor
     *
     * @param bool|null $result
     * @param int|null  $code
     */
    public function __construct(?bool $result = null, ?int $code = null)
    {
        $this->code = self::defineCode($result, $code);
        if ($this->code === self::CODE_SUCCESS) {
            $this->status = self::STATUS_SUCCESS;
        } else {
            $this->status = self::STATUS_ERROR;
        }
    }

    /**
     * Отправка ответа
     *
     * @param string $message
     * @param array  $additionalData
     * @return void
     */
    public function send(string $message, array $additionalData = []): void
    {
        self::setHttpCode($this->code);
        $body = array_merge(['status' => $this->status, 'message' => $message], $additionalData);
        echo json_encode($body, JSON_INVALID_UTF8_IGNORE);
    }

    /**
     * Определение кода ответа
     *
     * @param bool|null $result
     * @param int|null  $code
     * @return int
     */
    private static function defineCode(?bool $result = null, ?int $code = null): int
    {
        if (!is_null($result)) {
            return ($result) ? self::CODE_SUCCESS : self::CODE_ERROR;
        } elseif (!is_null($code) && $code >= 100 && $code < 600) {
            return $code;
        } else {
            return self::CODE_404;
        }
    }

    /**
     * Отправка заголовка
     *
     * @param int $code
     * @return void
     */
    public static function setHttpCode(int $code): void
    {
        header("HTTP/1.1 $code " . self::CODE_TEXT[$code]);
    }
}
