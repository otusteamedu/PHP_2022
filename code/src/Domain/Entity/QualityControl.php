<?php


namespace Study\Cinema\Domain\Entity;


use Study\Cinema\Domain\Interface\EventListener;

class QualityControl implements EventListener
{
    public function update(string $data)
    {
        echo " --Пришло сообщение о качестве заказа -- ".PHP_EOL .$data.PHP_EOL ;
    }

}