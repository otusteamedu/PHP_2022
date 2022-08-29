<?php

namespace Mselyatin\Queue\application\interfaces;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
interface QueueInterface
{
    /**
     * Add message to queue
     *
     * @param QueueJobInterface $job
     * @param string $queue
     * @param int $delay
     * @return mixed
     */
    public function push(QueueJobInterface $job, string $queue, int $delay = 0);

    /**
     * Listen queue
     *
     * @param string $queue
     * @return mixed
     */
    public function listen(string $queue): void;
}