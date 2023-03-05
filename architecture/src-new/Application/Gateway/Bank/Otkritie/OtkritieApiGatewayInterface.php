<?php

namespace App\Application\Gateway\Bank;

use App\Application\DTO\Bank\Otkritie\Response\Main;

interface OtkritieApiGatewayInterface
{
    public function enterApplication($requestFile): Main;
}