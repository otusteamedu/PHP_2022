<?php
declare(strict_types=1);
namespace Otus\Task10\Core\View;

use Otus\Task10\Core\View\Contracts\ViewCompilerContract;

class ViewManager
{

    public function __construct(private string $directoryStoreViews){}

    public function make(array $data, string $view): ViewCompilerContract
    {
        return new ViewCompiler($data, $this->directoryStoreViews . DIRECTORY_SEPARATOR .  $view);
    }

}