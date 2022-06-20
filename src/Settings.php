<?php
declare(strict_types=1);

namespace Igor\Php2022;

use Noodlehaus\Config;

class Settings
{
    const CONFIG_PATH = '/etc/chat/config.ini';

    private $config;

    public function __construct()
    {
        $this->config = Config::load(self::CONFIG_PATH);
    }

    public function get(string $key)
    {
        return $this->config->get($key);
    }
}