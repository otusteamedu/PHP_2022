<?php


namespace App\Services\QueueInterfaces;


interface ConsumerQueueInterface
{
    public function handle(): void;
}
