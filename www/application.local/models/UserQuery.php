<?php

namespace app\models;

use app\services\DBService;
use app\services\RabbitmqService;
use PhpAmqpLib\Message\AMQPMessage;

class UserQuery {
    private ?int $id;
    private ?string $status;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function updateInDB(): void {
        $pdo = DBService::get()->connect();
        $sql = 'UPDATE user_query set status=:status WHERE id=:id;';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->getId());
        $query->bindValue(':status', $this->getStatus());
        if (!$query->execute()) {
            throw new \Exception('Не удалось сохранить запрос в базу.');
        }
    }

    public function insertToDB(): void {
        $pdo = DBService::get()->connect();
        $sql = 'INSERT INTO user_query(status) VALUES (\'new\');';
        $query = $pdo->prepare($sql);
        if (!$query->execute()) {
            throw new \Exception('Не удалось сохранить запрос в базу.');
        }
        $this->id = $pdo->lastInsertId();
    }

    public function publishMessage(): void {
        $connection = (new RabbitmqService())->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('userQueries', false, false, false, false);
        $msg = new AMQPMessage($this->getId());
        $channel->basic_publish($msg, '', 'userQueries');

        $channel->close();
        $connection->close();
    }

    public static function findById(int $id): ?self {
        $pdo = DBService::get()->connect();
        $sql = 'SELECT * FROM user_query where id = :id;';
        $query = $pdo->prepare($sql);
        $query->execute(['id' => $id]);
        $result = $query->fetch();
        if ($result) {
            $model = new self();
            $model->setId($result['id']);
            $model->setStatus($result['status']);
            return $model;
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

}
