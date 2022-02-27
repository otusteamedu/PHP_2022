<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Core;

use Devanych\View\Renderer;

class Render
{
    private $dir = __DIR__ . '/../views';
    private Renderer $renderer;

    public function __construct()
    {
        $this->renderer = new Renderer($this->dir);
    }

    public function compile(string $page, array $params): ?string
    {
        return $this->renderer->render($page, $params);
    }
}