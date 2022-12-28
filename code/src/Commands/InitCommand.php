<?php

namespace Ppro\Hw13\Commands;

use Ppro\Hw13\App;
use Ppro\Hw13\Views\InitView;

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