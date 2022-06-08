<?php
declare(strict_types=1);

namespace Shilyaev\Chat;

class App
{
    protected $settings;
    protected $mode;

    public function __construct()
    {
        if (PHP_SAPI != 'cli')
            throw new \Exception('Прилоджение может быть запущего только в режиме CLI.');

        if (($this->settings = parse_ini_file("config.ini"))===false)
            $this->settings=[];

        $this->mode = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL;
    }

    public function run() : void
    {
        switch ($this->mode)
        {
            case 'server':
                $server = new Server();
                $server->init($this->settings);
                $server->run();
                break;
            case 'client':
                $client = new Client();
                $client->init($this->settings);
                $client->run();
                break;
            default:
                throw new \Exception('Неверный параметр запуска приложения (chat или server)');
        }
    }
}