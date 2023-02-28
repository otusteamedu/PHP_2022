<?php

namespace App\Domain\Contract;

interface HasQueueInterface
{

    public function toAMPQMessage(): string;

}
