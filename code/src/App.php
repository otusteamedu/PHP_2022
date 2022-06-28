<?php

namespace Roman\Shum;



use Roman\Shum\Socket\Socket;


class App{

    /**
     * @var string|mixed
     */
    public string $controller='';

    /**
     *
     */
    public function __construct(){
        $this->controller=strtolower($_SERVER['argv'][1]);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        if($this->controller==='server'){
            $socket = new Socket(true);
            $server = new Server($socket);
            $server->start_listen();
        }elseif($this->controller==='client'){
            $socket = new Socket();
            $client = new Client($socket);
            $client->send();
        }else{
            throw new \Exception('Unknown method');
        }
    }
}