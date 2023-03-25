<?php

declare(strict_types=1);

namespace Ppro\Hw28\Controller\Statement;

use Ppro\Hw28\Controller\BaseController;

/**
 *
 */
abstract class Base extends BaseController
{
    /** Возвращает Сервис, отвечающий за создание заявки
     * @return \Ppro\Hw28\Service\Statement\Create
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getServiceCreateStatement(): \Ppro\Hw28\Service\Statement\Create
    {
        return $this->container->get('create_statement_service');
    }

    /** Возвращает Сервис, отвечающий за получение статуса заявки
     * @return \Ppro\Hw28\Service\Statement\GetOne
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getServiceFindStatement(): \Ppro\Hw28\Service\Statement\GetOne
    {
        return $this->container->get('find_statement_service');
    }
}
