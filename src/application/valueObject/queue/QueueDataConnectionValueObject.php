<?php

namespace Mselyatin\Queue\application\valueObject\queue;

use \InvalidArgumentException;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class QueueDataConnectionValueObject
{
    /** @var string  */
    private string $host;

    /** @var int  */
    private int $port;

    /** @var string  */
    private string $user;

    /** @var string  */
    private string $password;

    /** @var string  */
    private string $vhost;

    /** @var float  */
    private float $connectionTimeout;

    /** @var float  */
    private float $connectionWrite;

    /**
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     */
    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password,
        float $connectionTimeout,
        float $connectionWrite,
        string $vhost = '/'
    ) {
        if (empty($host) || empty($port) || empty($user)) {
            throw new InvalidArgumentException(
                'Error! Parameters: host, port or user is empty'
            );
        }

        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->connectionTimeout = $connectionTimeout;
        $this->connectionWrite = $connectionWrite;
        $this->vhost = $vhost;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return float
     */
    public function getConnectionTimeout(): float
    {
        return $this->connectionTimeout;
    }

    /**
     * @return float
     */
    public function getConnectionWrite(): float
    {
        return $this->connectionWrite;
    }
}