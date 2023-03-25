<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller\Cli;

use adrianfalleiro\SlimCliRunner\CliAction;
use Ppro\Hw28\Service\Statement\Statement;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;

/** Обработка CLI команды statement
 * (обработчик очереди запросов)
 */
class StatementController extends CliAction
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    /**
     * @return Response
     */
    public function action(): Response
    {
        $this->getServiceProcessingStatement()->run();
        return $this->respond();
    }

    /** Возвращает Сервис, отвечающий за обработку заявок
     * @return Statement
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getServiceProcessingStatement(): Statement
    {
        return $this->container->get('processing_statement_service');
    }
}
