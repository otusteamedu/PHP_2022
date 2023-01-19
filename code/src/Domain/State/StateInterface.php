<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\State;

/**
 * State interface
 */
interface StateInterface
{
    /**
     * @return void
     */
    public function fryCutlet(): void;

    /**
     * @return void
     */
    public function boilSausage(): void;

    /**
     * @return void
     */
    public function addSauces(): void;

    /**
     * @return void
     */
    public function cutBun(): void;

    /**
     * @return void
     */
    public function addIngredients(): void;

    /**
     * @return void
     */
    public function done(): void;

    /**
     * @return string
     */
    public function getStringState(): string;
}
