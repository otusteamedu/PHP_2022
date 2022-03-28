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
    private $layout;

    /**
     * @var string блок с выводом результат
     */
    private $result;

    /**
     * @var mixed|string Заголовок страницы
     */
    private $template_h1;

    /**
     * Constructor
     */
    public function __construct($template_h1 = '')
    {
        $this->template_h1 = $template_h1;
        $this->layout = 'layout.php';
        $this->result = 'response.php';
    }

    /**
     * Вывод страницы
     *
     * @param ServerData $obData
     * @return void
     */
    public function page(ServerData $obData)
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
    public function result(ServerData $obData, BracketsValidator $obValidator)
    {
        require self::DIR_TEMPLATE . '/' . $this->result;
    }
}