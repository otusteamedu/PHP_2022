<?php


namespace Decole\Hw13\Core\Services;


class FlushEventService
{
    public function flushAll(): void
    {
        (new StorageService())->flush();
    }
}