<?php

namespace Mselyatin\Patterns\application\events;

use Mselyatin\Patterns\domain\interfaces\events\EventAfterInterface;

class FastFoodProxyAfterEvent implements EventAfterInterface
{
    public function after(...$params): mixed
    {
        echo 'Отработало событие после создания продукта. <br>';
        return true;
    }
}