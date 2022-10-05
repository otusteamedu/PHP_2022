<?php
declare(strict_types=1);

namespace App\Common;

use App\Model\ConfigInterface;

class Config implements ConfigInterface
{
    /**
     * @var
     */
    protected $conf;

    /**
     * @param $conf
     */
    public function __construct()
    {
        $this->conf = parse_ini_file(dirname(__FILE__) . '/../config.ini', true);
    }

    public function get(string $key){
        if (!isset($this->conf[$key]))
            throw new \InvalidArgumentException("Config key {$key} does not exists!");
        return $this->conf[$key];
    }

}