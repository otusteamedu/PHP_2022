<?php

namespace Sbbs\PdoDb\Src;

use PDO;
use PDOException;

class PdoDb
{
    private static PdoDb $instance;

    private $pdo;
    private $log;

    private $query;
    private $parameters;
    private $method;

    private $host;
    private $dbname;
    private $dsn;
    private $user;
    private $pswd;
    private $port;

    private function __construct(array $db_config)
    {
        $this->host = $db_config['DB_HOST'];
        $this->port = $db_config['DB_PORT'];
        $this->dbname = $db_config['DB_NAME'];
        $this->user = $db_config['DB_USER'];
        $this->pswd = $db_config['DB_PSWD'];
        $this->dsn = "mysql:host=$this->host:$this->port; dbname=$this->dbname; charset=utf8mb4";
    }

    private function __clone()
    {
    }

    public static function getInstance($db_config): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($db_config);
        }
        return self::$instance;
    }

    private function connect()
    {
        if (!$this->pdo) {
            try {
                $this->pdo = new PDO($this->dsn, $this->user, $this->pswd);
            } catch (PDOException $error) {
                echo $error->getMessage();
                exit;
            }
        }
        return $this->pdo;
    }

    private function callDB()
    {
        $this->connect();
        $startTime = microtime(1);
        $callDB = $this->pdo->prepare($this->query);
        $result = $callDB->execute($this->parameters);
        $timeFinal = $startTime - microtime(1);
        if (!$result) {
            if ($callDB->errorCode()) {
                trigger_error(json_encode($callDB->errorInfo()));
            }
            return false;
        }
        $this->log[] = [
            'query' => $this->query,
            'time' => $timeFinal,
            'method' => $this->method,
        ];
        return $callDB;
    }

    public function exec(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();

        return $callDB->rowCount();
    }

    public function fetchAll(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();

        return $callDB->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchOne(string $query, array $parameters = [], string $method = '')
    {
        $this->query = $query;
        $this->parameters = $parameters;
        $this->method = $method;
        $callDB = $this->callDB();
        $result = $callDB->fetchAll(PDO::FETCH_ASSOC);

        return reset($result);
    }

    public function getLastId()
    {
        $this->connect();
        return $this->pdo->lastInsertId();
    }

    public function getLog()
    {
        $this->connect();
        return $this->log;
    }
}
