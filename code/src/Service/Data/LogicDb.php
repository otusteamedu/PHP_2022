<?php

declare(strict_types=1);

namespace App\Service\Data;

use App\Entity\JsonEvent;
use RuntimeException;
use Symfony\Component\DependencyInjection\Container;

/**
 * LogicDb
 */
class LogicDb implements ILogic
{
    use LogicTrait;

    /**
     * @var array
     */
    public array $array;
    private $logger;

    /**
     * __construct
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
        $this->array = $this->getDoctrine()->getRepository(JsonEvent::class)->findAll();
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function logic() : void
    {
        if (!$this->array) {
            throw new RuntimeException('В объекте нет данных');
        }

        foreach ($this->array as $r) {
            $json = $r->getValue();
            $this->extracted($json);
        }
    }

    /**
     * @return mixed
     */
    public function getDoctrine(): mixed
    {
        return Container::getInstance()->get('doctrine');
    }
}