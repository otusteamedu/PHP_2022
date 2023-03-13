<?php

namespace Ppro\Hw27\App\Queue;

use Ppro\Hw27\App\Entity\DtoInterface;

interface QueueInterface
{
    public function setConfig(array $config);
    public function sendMessage(DtoInterface $data);

}