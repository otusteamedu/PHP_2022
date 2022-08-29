<?php

namespace Mselyatin\Queue\application\abstracts;

use Mselyatin\Queue\application\interfaces\QueueJobInterface;

/**
 * @property array $data
 *
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
abstract class QueueJobAbstract implements QueueJobInterface
{
    /** @var array  */
    public array $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Start job
     * @return void
     */
    public function execute(): void
    {
        $this->prepareData();
        $this->handle();
    }

    public function serialize(): string
    {
       return serialize($this);
    }

    /**
     * Processing the data before run to job
     */
    abstract protected function prepareData(): void;
}