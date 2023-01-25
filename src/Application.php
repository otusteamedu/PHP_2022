<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Application\Interface\OperationMapperInterface;
use Dkozlov\Otus\Domain\Operation;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\DepencyNotFoundException;

class Application
{
    private static Config $config;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct()
    {
        self::$config = new Config(__DIR__ . '/../config/config.ini');
    }

    /**
     * @throws ConnectionTimeoutException
     * @throws DepencyNotFoundException
     */
    public function run(): void
    {
        /**
         * @var OperationMapperInterface $mapper
         */
        $mapper = self::$config->depency(OperationMapperInterface::class);

        $mapper->save(new Operation(1, 'Dmitry', 300, new \DateTime()));
        $mapper->save(new Operation(2, 'Dmitry', 500, new \DateTime()));
        $mapper->save(new Operation(3, 'Dmitry', 700, new \DateTime()));

        echo 'Операции пользователя Dmitry <br>';

        foreach ($mapper->getPersonOperations('Dmitry') as $operation) {
            echo 'Операция#' . $operation->getId() . ' на сумму ' . $operation->getAmount() . '<br>';
        }

        $mapper->remove(1);
        $mapper->remove(2);
        $mapper->remove(3);
    }

    public static function config(string $name): mixed
    {
        return self::$config->get($name);
    }

}