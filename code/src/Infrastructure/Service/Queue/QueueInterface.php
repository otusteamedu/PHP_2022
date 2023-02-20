<?php


namespace Study\Cinema\Infrastructure\Service\Queue;


interface QueueInterface
{
    const QUEUE_NAME_STATEMENT = 'statement';
    const QUEUE_NAME_EMAIL = 'email';
    const QUEUE_NAME_REQUEST = 'request';

}