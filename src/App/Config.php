<?php
declare(strict_types=1);

namespace Qween\Php2022\App;

use Dotenv\Dotenv;

class Config
{
    private const CONFIG_FILE = '.env';

    /**
     * @var null[]|string[]
     */
    private array $config;

    public function __construct()
    {
        $env = Dotenv::createImmutable('./', self::CONFIG_FILE);
        $this->config = $env->load();
    }

    public function getParam(string $param, $default = null): ?string
    {
        return $this->config[$param] ?? $default;
    }
}
