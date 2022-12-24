<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\App\Kernel;

use Dotenv\Dotenv;
use Eliasjump\HwStoragePatterns\App\Exceptions\NoAttributeException;

/**
 * @property string $db_host
 * @property string $db_name
 * @property string $db_user
 * @property string $db_pass
 */
class Config
{
    use Singleton;

    private string $db_name;
    private string $db_user;
    private string $db_pass;
    private string $db_host;

    public function load(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $this->db_name = $_ENV['MYSQL_DATABASE'];
        $this->db_user = $_ENV['MYSQL_USER'];
        $this->db_pass = $_ENV['MYSQL_PASSWORD'];
        $this->db_host = $_ENV['DB_HOST'];
    }

    /**
     * @throws NoAttributeException
     */
    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new NoAttributeException($name);
        }
        return $this->$name;
    }
}