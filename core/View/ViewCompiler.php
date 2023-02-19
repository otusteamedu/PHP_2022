<?php


namespace Otus\Task13\Core\View;

use Exception;
use Otus\Task13\Core\View\Contracts\ViewCompilerContract;
use Stringable;

class ViewCompiler implements ViewCompilerContract, Stringable
{

    public function __construct(private array $data, private string $view)
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return $this->compiler();
    }

    private function compiler(): string
    {

        $file = $this->view . '.php';
        if (!is_file($file)) {
            throw new Exception(sprintf('Файл "%s" шаблонизатора не найден', $file));
        }
        ob_start();
        extract($this->data);
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}