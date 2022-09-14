<?php

namespace Mselyatin\Patterns\application\events;

use Mselyatin\Patterns\domain\interfaces\events\EventBeforeInterface;

class FastFoodProxyBeforeEvent implements EventBeforeInterface
{
    public function before(...$params): mixed
    {
        echo 'Отработало событие до создания продукта. <br>';
        return true;
    }
}