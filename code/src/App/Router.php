<?php

declare(strict_types=1);

namespace Kogarkov\Es\App;

use Kogarkov\Es\Core\Service\Action;
use Kogarkov\Es\Core\Service\Registry;

class Router
{
    private $request;
    private $registry;

    public function __construct()
    {
        $this->registry = Registry::instance();
        $this->request = $this->registry->get('request');
    }

    public function run(): void
    {
        $route = $this->request->server['REQUEST_URI'];
        $param_char_pos = strpos((string)$route, '?');
        $route = substr((string)$route, 1, $param_char_pos !== false ? $param_char_pos - 1 : strlen($route));
        $action = new Action($route);
        $action->execute($this->registry);
    }
}
