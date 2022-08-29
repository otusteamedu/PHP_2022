<?php

namespace Mselyatin\Queue\application\interfaces;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
interface QueueJobInterface
{
    public function handle(): void;

    public function serialize(): string;

    public function execute(): void;
}