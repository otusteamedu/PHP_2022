<?php

namespace Mselyatin\Patterns\domain\interfaces\models;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\valueObjects\bakery\BakeryTypeValue;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

/**
 * Хлебобулочное изделие
 */
interface BakeryInterface
{
    /**
     * Тип хлебобулочного изделия
     * @return BakeryTypeValue
     */
    public function getType(): BakeryTypeValue;

    /**
     * Состав хлебобулочного изделия
     * @return CollectionInterface
     */
    public function getComposition(): CollectionInterface;

    /**
     * Установить новый статус готовности
     * @param ReadinessStatusValue $readinessStatusValue
     * @return void
     */
    public function setStatus(ReadinessStatusValue $readinessStatusValue): void;

    /**
     * @return ReadinessStatusValue
     */
    public function getStatus(): ReadinessStatusValue;
}