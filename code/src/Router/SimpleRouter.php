<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Router;

use Ekaterina\Hw4\ServerData\ServerData;

class SimpleRouter
{
    /**
     * Действия, допустимые в приложении
     */
    public const ACTION_INDEX = 'index';
    public const ACTION_VALIDATE = 'validate';
    public const ACTION_NOT_FOUND = '404';

    /**
     * @var string|null Страница приложения
     */
    private ?string $page;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->page = parse_url(ServerData::getServerInfo('REQUEST_URI'), PHP_URL_PATH);
    }

    /**
     * Определение какое действие выполнять в зависимости от страницы
     *
     * @return string
     */
    public function getAction(): string
    {
        switch ($this->page) {
            case '/validate':
                return self::ACTION_VALIDATE;
            case '/':
                return self::ACTION_INDEX;
            default:
                return self::ACTION_NOT_FOUND;
        }
    }
}