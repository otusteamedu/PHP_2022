<?php

namespace app\Domain\CookBuilder;

interface CookBuilderInterface {
    public function prepareTools(): string;
    public function addIngredients(): string;
    public function cook(): string;
}
