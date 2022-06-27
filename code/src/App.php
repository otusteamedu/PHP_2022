<?php

namespace Roman\Shum;



use Roman\Shum\Socket\Socket;


class App{

    /**
     * @var string|mixed
     */
    public string $argv='';

    /**
     *
     */
    public function __construct(){
        $this->argv=strtolower($_SERVER['argv'][1]);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        if($this->argv==='server'){
            $socket = new Socket(true);
            $server = new Server($socket);
            $server->start_listen();
        }elseif($this->argv==='client'){
            $socket = new Socket();
            $client = new Client($socket);
            $client->send();
        }else{
            throw new \Exception('Unknown method');
        }
    }
}