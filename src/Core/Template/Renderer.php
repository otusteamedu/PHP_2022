<?php declare(strict_types = 1);

namespace Queen\App\Core\Template;

interface Renderer
{
    public function render($template, $data = []) : string;
}
