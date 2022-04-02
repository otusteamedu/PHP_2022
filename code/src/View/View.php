<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\View;

use Ekaterina\Hw4\ServerData\ServerData;
use Ekaterina\Hw4\Validator\BracketsValidator;

class View
{
    /**
     * Путь до шаблона
     */
    private const DIR_TEMPLATE = 'src/templates';

    /**
     * @var string Основной макет страницы
     */
    private string $layout;

    /**
     * @var string блок с выводом результат
     */
    private string $result;

    /**
     * @var string блок с выводом результат
     */
    private string $notFound;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->layout = 'layout.php';
        $this->result = 'response.php';
        $this->notFound = '404.php';
    }

    /**
     * Вывод страницы
     *
     * @param ServerData $obData
     * @return void
     */
    public function page(ServerData $obData): void
    {
        require self::DIR_TEMPLATE . '/' . $this->layout;
    }

    /**
     * Вывод результата
     *
     * @param ServerData        $obData
     * @param BracketsValidator $obValidator
     * @return void
     */
    public function result(ServerData $obData, BracketsValidator $obValidator): void
    {
        require self::DIR_TEMPLATE . '/' . $this->result;
    }

    /**
     * Вывод 404 страницы
     *
     * @return void
     */
    public function notFound(): void
    {
        require self::DIR_TEMPLATE . '/' . $this->notFound;
    }
}