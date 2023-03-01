<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Food;

use Nikcrazy37\Hw14\Libs\Config;

class SandwichFood extends AbstractFood
{
    /**
     * @return array
     */
    public function createRecipe(): array
    {
        $configRecipe = Config::getOption("SANDWICH_RECIPE");

        return $this->prepareRecipe($configRecipe);
    }
}