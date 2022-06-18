<?php

namespace Patterns\App\Application\Service;

interface MoneyIssuingService
{
    public function giveOut(int $sum): array;
}