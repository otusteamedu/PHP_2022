<?php

namespace Ppro\Hw27\Consumer\Queue;

use Ppro\Hw27\Consumer\Entity\DtoInterface;

interface QueueInterface
{
    public function setConfig(array $config);
    public function sendMessage(DtoInterface $data);

}