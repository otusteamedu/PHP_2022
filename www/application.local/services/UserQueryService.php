<?php

namespace app\services;

use app\models\UserQuery;
use PhpAmqpLib\Message\AMQPMessage;

class UserQueryService {
    private UserQuery $model;

    public function __construct(UserQuery $userQuery) {
        $this->model = $userQuery;
    }

    public function getModel(): UserQuery {
        return $this->model;
    }

    public function updateInDB(): void {
        $pdo = DBService::get()->connect();
        $sql = 'UPDATE user_query set status=:status WHERE id=:id;';
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $this->model->getId());
        $query->bindValue(':status', $this->model->getStatus());
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
        $this->model->setId($pdo->lastInsertId());
    }

    public static function getFromDb(int $queryId): UserQuery {
        $pdo = DBService::get()->connect();
        $sql = 'SELECT * FROM user_query where id = :id;';
        $query = $pdo->prepare($sql);
        $query->execute(['id' => $queryId]);
        $result = $query->fetch();
        if ($result) {
            $model = new UserQuery();
            $model->setId($result['id']);
            $model->setStatus($result['status']);
            return $model;
        }
        throw new \Exception('Not found', 404);
    }

    public function publishMessage(): void {
        $connection = (new RabbitmqService())->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('userQueries', false, false, false, false);
        $msg = new AMQPMessage($this->model->getId());
        $channel->basic_publish($msg, '', 'userQueries');

        $channel->close();
        $connection->close();
    }
}
