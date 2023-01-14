<?php

declare(strict_types=1);

namespace Chernysh\Hw4\Service;

use Chernysh\FishText\FishText;

class FishService
{

    public function getText(): void
    {
        $fish = new FishText();
        var_dump($fish->loadSentence());
    }

}