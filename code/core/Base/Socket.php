<?php

namespace Core\Base;

use Core\Helpers\Config;
use Core\Exceptions\InvalidArgumentException;
use Core\Exceptions\InvalidApplicationConfig;
use Core\Helpers\Console;

class Socket
{
    /**
     * @var Config $config
     */
    private Config $config;

    private string $socket_file;
    private $sock;
    private int $bytes = 2048;

    /**
     * @throws InvalidApplicationConfig
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->preInit();
    }

    /**
     * @return void
     * @throws InvalidApplicationConfig
     */
    public function preInit() :void
    {
        if (count($this->config->getItems()) > 0) {
            foreach ($this->config->getItems() as $key => $param) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $param;
                }
            }
        }

        if (!isset($this->socket_file)) {
            throw new InvalidApplicationConfig($this->errorMessage('The "socket_file" configuration is required.'));
        }
    }

    /**
     * @var bool $rm_sock_file
     * @return $this
     * @throws InvalidArgumentException
     */
    public function socketCreate(bool $rm_sock_file = true) :Socket
    {
        if ($rm_sock_file) {
            unlink($this->socket_file);
        }

        if (($this->sock = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            return $this;
        }

        throw new InvalidArgumentException($this->errorMessage('socket_create() failed: reason'));
    }

    /**
     * @return Socket
     * @throws InvalidArgumentException
     */
    public function socketBind() :Socket
    {
        if (socket_bind($this->sock, $this->socket_file)) {
            return $this;
        }

        throw new InvalidArgumentException($this->errorMessage('Socket_bind() failed reason'));
    }

    /**
     * @return $this
     * @throws InvalidArgumentException
     */
    public function socketListen() :Socket
    {
        if (socket_listen($this->sock, 5)) {
            return $this;
        }

        throw new InvalidArgumentException($this->errorMessage('socket_listen() failed: reason'));
    }

    /**
     * @return resource|\Socket
     * @throws InvalidArgumentException
     */
    public function socketAccept()
    {
        if ($msg_sock = socket_accept($this->sock)) {
            return $msg_sock;
        }

        throw new InvalidArgumentException($this->errorMessage('socket_accept() failed: reason: '));
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function socketConnect() :void
    {
        if (socket_connect($this->sock, $this->socket_file)) {
            Console::show('connect success');
        } else {
            throw new InvalidArgumentException($this->errorMessage('socket_create() failed: reason'));
        }
    }

    /**
     * @param $sock
     * @param string $msg
     * @return void
     */
    public function socketWrite(string $msg, $sock = null) :void
    {
        $sock = $sock ?: $this->sock;

        socket_write($sock, $msg, strlen($msg));
    }

    /**
     * @param $sock
     * @return string
     * @throws InvalidArgumentException
     */
    public function socketRead($sock =  null) :string
    {
        $sock = $sock ?: $this->sock;

        if (($buf = socket_read($sock, $this->bytes)) !== false) {
            return $buf;
        }

        throw new InvalidArgumentException($this->errorMessage('socket_read() failed: reason'));
    }

    /**
     * @param $sock
     * @return array
     * @throws InvalidArgumentException
     */
    public function socketRecv($sock =  null) :array
    {
        $sock = $sock ?: $this->sock;
        $buf = '';

        if ($bytes = socket_recv($sock, $buf, $this->bytes, 0)) {
            return ['buf' => $buf, 'bytes' => $bytes];
        }

        throw new InvalidArgumentException($this->errorMessage('socket_recv() failed: reason'));
    }

    /**
     * @param $sock
     * @return void
     */
    public function socketClose($sock = null) :void
    {
        $sock = $sock ?? $this->sock;
        socket_close($sock);
    }

    /**
     * @return mixed
     */
    public function getSock()
    {
        return $this->sock;
    }

    /**
     * @return string
     */
    public function getSockFile() :string
    {
        return $this->socket_file;
    }

    /**
     * @param string $msg
     * @return string
     */
    private function errorMessage(string $msg) : string
    {
        $error_code = socket_last_error();
        $error_msg = socket_strerror($error_code);

        return $msg . ': [' . $error_code . '] ' . $error_msg . PHP_EOL;
    }
}