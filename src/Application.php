<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Application\Interface\OperationMapperInterface;
use Dkozlov\Otus\Domain\Operation;
use Dkozlov\Otus\Exception\ConfigNotFoundException;

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

    public function run(): void
    {
        /**
         * @var OperationMapperInterface $mapper
         */
        $mapper = self::$config->depency(OperationMapperInterface::class);

        $operation = new Operation(1, 'Dmitry', 300, new \DateTime());

        $mapper->save($operation);

        echo 'Операцию совершил ' . $operation->getPerson() . ' на сумму ' . $operation->getAmount() . '<br>';

        $operation->setAmount(500);

        $mapper->update($operation);

        echo 'Или на сумму ' . $operation->getAmount() . '<br>';

        $mapper->remove(1);
    }

    public static function config(string $name): mixed
    {
        return self::$config->get($name);
    }

}