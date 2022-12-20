<?php


namespace Otus\Task07\Core\View;

use Otus\Task07\Core\View\Contracts\ViewCompilerContract;
use Stringable;

class ViewCompiler implements ViewCompilerContract, Stringable
{

    public function __construct(private array $data, private string $view){}

    private function compiler(): string{

        $file = $this->view . '.php';
        if(!is_file($file)){
            throw new \Exception(sprintf('Файл "%s" шаблонизатора не найден', $file));
        }
        ob_start();
        extract($this->data);
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function render(): string{
       return $this->compiler();
    }

    public function __toString(): string
    {
        echo 'df';
        return $this->render();
    }
}