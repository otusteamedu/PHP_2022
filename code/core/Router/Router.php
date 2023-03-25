<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Router;

use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Core\Router\Action;

class Router
{
    private $request;

    public function __construct()
    {
        $registry = Registry::instance();
        $this->request = $registry->get('request');
    }

    public function run(): void
    {
        $route = $this->request->getServerParam('REQUEST_URI');
        $param_char_pos = strpos((string)$route, '?');
        $route = substr((string)$route, 1, $param_char_pos !== false ? $param_char_pos - 1 : strlen($route));
        $action = new Action($route);
        $action->execute();
    }
}
