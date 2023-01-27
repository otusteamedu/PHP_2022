<?php

namespace App\Services\Interfaces;

interface ConsumerQueueInterface
{
    /**
     * @param ReportExecuteHandlerInterface $handler
     * @return void
     */
    public function handle(ReportExecuteHandlerInterface $handler): void;
}
