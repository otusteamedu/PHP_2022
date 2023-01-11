<?php


namespace Study\Cinema\Infrastructure;


abstract class Food
{
    const FOOD_STATE_OK = 1;
    const FOOD_STATE_BURNT = 2;
    const FOOD_STATE_UNCOOKED = 3;

    private int $state;

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState(int $state): void
    {
        $this->state = $state;
    }





}