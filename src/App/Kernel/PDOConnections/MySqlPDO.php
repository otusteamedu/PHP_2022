<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\App\Kernel\PDOConnections;

use Eliasjump\HwStoragePatterns\App\Kernel\Config;
use Exception;
use PDO;

trait MySqlPDO
{
    private PDO $pdo;
    /**
     * @throws Exception
     */
    private function createPdo(): void
    {
        $config = Config::getInstance();
        $pdo = new PDO(
            "mysql:host={$config->db_host};dbname={$config->db_name}",
            $config->db_user,
            $config->db_pass,
        );
        if (!$pdo) {
            throw new Exception("Can't connect to database");
        }
        $this->pdo = $pdo;
    }
}