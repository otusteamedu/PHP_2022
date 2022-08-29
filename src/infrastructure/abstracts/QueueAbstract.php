<?php

namespace Mselyatin\Queue\infrastructure\abstracts;

use Mselyatin\Queue\application\valueObject\queue\QueueDataConnectionValueObject;
use Mselyatin\Queue\application\interfaces\QueueInterface;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
abstract class QueueAbstract implements QueueInterface
{
    /** @var QueueDataConnectionValueObject  */
    protected QueueDataConnectionValueObject $dataConnection;

    /**
     * @param QueueDataConnectionValueObject $dataConnection
     */
    public function __construct(QueueDataConnectionValueObject $dataConnection)
    {
        $this->dataConnection = $dataConnection;
    }
}