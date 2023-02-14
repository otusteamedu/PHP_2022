<?php

namespace Ppro\Hw15\Commands;

use Ppro\Hw15\App;
use Ppro\Hw15\Views\InitView;

/** Вывод основного меню
 *
 */
class InitCommand extends Command
{
    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $view = new InitView();
        $view->render();
        $inputCmd = $view->getInput()->prompt();

        App::forward($inputCmd);
    }
}