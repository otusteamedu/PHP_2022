<?php

namespace Mselyatin\Project15\src\common\storages;

use Mselyatin\Project15\src\common\interfaces\StorageInterface;
use InvalidArgumentException;
use PDO;

/**
 * Class DbStorage
 * @package Mselyatin\Project15\src\common\storages
 */
class DbStorage implements StorageInterface
{
    /** @var ?PDO  */
    public ?PDO $pdo = null;

    /** @var DbStorage|null $this|null  */
    private static ?self $instance = null;

    /**
     * DbStorage constructor.
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbname
     * @param string $port
     * @param array $options
     */
    private function __construct(
      string $host,
      string $user,
      string $password,
      string $dbname,
      string $port = "5432",
      array $options = []
    ) {
        $this->pdo = new PDO(
            "pgsql:host=$host;port=$port;dbname=$dbname;",
            $user,
            $password,
            $options
        );

        if (!$this->pdo) {
            throw new InvalidArgumentException(
                'Не удалось подключиться к бд'
            );
        }
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbname
     * @param string $port
     * @param array $options
     * @return static
     */
    public static function getInstance(
        string $host,
        string $user,
        string $password,
        string $dbname,
        string $port = "5432",
        array $options = []
    ): self {
        return static::$instance ?? new static(
                $host,
                $user,
                $password,
                $dbname,
                $port,
                $options
            );
    }
}