<?php

namespace Otus\Task14\Factory\Contract;

interface ProductInterface
{
    public function getName(): string;

    public function setIngredients($ingredients);
    public function getIngredients();
}