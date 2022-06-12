<?php


namespace App\Services\Interfaces;


interface ConsumerQueueInterface
{
    public function handle(ReportExecuteHandlerInterface $handler): void;
}
