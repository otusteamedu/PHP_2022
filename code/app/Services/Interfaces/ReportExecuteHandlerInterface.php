<?php


namespace App\Services\Interfaces;


interface ReportExecuteHandlerInterface
{
    public function process(int $id): void;

    public function setStatusQueue(int $id, string $status): void;
}
