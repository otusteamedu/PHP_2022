<?php

declare(strict_types=1);

namespace Svatel\Code\Domain;

use PDO;
use Svatel\Code\Domain\Pdo\PdoDomainInterface;

final class SubscribeMapper
{
    private PdoDomainInterface $pdo;

    public function __construct(PdoDomainInterface $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Subscriber $event): bool
    {
        try {
            $query = "INSERT INTO `subscriber` (`id` , `event_id`, `users`) VALUES (:id, :event_id, :users)";
            $params = [
                ':id' => $event->getId(),
                ':event_id' => $event->getEventId(),
                ':users' => json_encode($event->getUsers())
            ];
            $stmt = $this->pdo->getClient()->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function findByUserIdAndType(int $typeId, ?int $userId = null): ?Subscriber
    {
        if (!is_null($userId)) {
            $query = "SELECT * FROM subscriber WHERE `event_id` = ? AND `users` = ?";
            $params = [$typeId, $userId];
        } else {
            $query = "SELECT * FROM subscriber WHERE `event_id` = ?";
            $params = [$typeId];
        }
        $stmt = $this->pdo->getClient()->prepare($query);
        $stmt->execute($params);
        $subscriberArray = $stmt->fetch(PDO::FETCH_LAZY);

        if (empty($subscriberArray)) {
            return null;
        }

        $subscriber = new Subscriber();
        $subscriber->setId((int) $subscriberArray['id']);
        $subscriber->setEventId((int) $subscriberArray['event_id']);
        $subscriber->setUser(json_decode($subscriberArray['user']));

        return $subscriber;
    }

    public function update(int $userId, int $eventId): bool
    {
        try {
            $subscriber = $this->findByUserIdAndType($userId, $eventId);
            $users = $subscriber->getUsers();
            $users[] = $userId;
            $query = "UPDATE `subscriber` SET users = :users WHERE `event_id` = :event_id";
            $stmt = $this->pdo->getClient()->prepare($query);
            $params = [
                ':event_id' => $eventId,
                ':users' => json_encode($users)
            ];
            $stmt->execute($params);
        } catch (\Exception $e) {
            return false;
        }
    }
}
