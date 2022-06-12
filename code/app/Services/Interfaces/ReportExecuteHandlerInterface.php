<?php


namespace App\Services\Interfaces;


interface ReportExecuteHandlerInterface
{
    public function process(int $id): void;

    public function setInQueue(int $id, string $status): void;
}
