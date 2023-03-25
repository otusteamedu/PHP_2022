<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller\Cli;

use adrianfalleiro\SlimCliRunner\CliAction;
use Slim\Psr7\Response;

/** Обработка дефолтной CLI команды
 *
 */
class DefaultController extends CliAction
{
    /**
     * @return Response
     */
    public function action(): Response
    {

        $this->logToConsole("Not defined task");
        return $this->respond();

    }
}
