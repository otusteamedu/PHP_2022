<?php

declare(strict_types=1);

namespace Core\Storage\Mysql;

use Core\Service\Container;
use Core\Storage\Contract\StorageClientInterface;
use Core\Storage\Mysql\Query;

class Client implements StorageClientInterface
{
    private $client;
    private $config;

    public function __construct()
    {
        $this->config = Container::instance()->get('config');
        $this->client = new \mysqli(
            $this->config->get('db_host'),
            $this->config->get('db_user'),
            $this->config->get('db_password'),
            $this->config->get('db_name'),
            (int)$this->config->get('db_port')
        );

        if ($this->client->connect_error) {
            throw new \Exception('Error: ' . $this->client->error . '<br />Error No: ' . $this->client->errno);
        }

        $this->client->set_charset("utf8");
        $this->client->query("SET SQL_MODE = ''");
    }

    public function get(): \mysqli
    {
        return $this->client;
    }

    public function query($sql): Query
    {
        $query = $this->client->query($sql);

        if (!$this->client->errno) {

            $result = new Query();

            if ($query instanceof \mysqli_result) {
                $data = array();

                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }

                $result
                    ->setNumRows($query->num_rows)
                    ->setRow(isset($data[0]) ? $data[0] : array())
                    ->setRows($data);

                $query->close();
            }

            return $result;
        } else {
            throw new \Exception('Error: ' . $this->client->error  . '<br />Error No: ' . $this->client->errno . '<br />' . $sql);
        }
    }

    public function escape($value): string
    {
        return $this->client->real_escape_string($value);
    }

    public function getLastId(): int
    {
        return $this->client->insert_id;
    }

    public function countAffected(): int
    {
        return $this->client->affected_rows;
    }
}
