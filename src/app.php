<?php

declare(strict_types=1);

require_once dirname(__DIR__).'/vendor/autoload.php';

use Olelishna\Diceroller\Dice;

$roll = Dice::roll(20);

echo $roll."\n";