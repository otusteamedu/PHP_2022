<?php

declare(strict_types=1);

namespace Svatel\Code\Domain;

use PDO;
use Svatel\Code\Domain\Pdo\PdoDomainInterface;

final class EventMapper
{
    private PdoDomainInterface $pdo;

    public function __construct(PdoDomainInterface $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Event $event): bool
    {
        try {
            $query = "INSERT INTO `event` (`id` , `type`, `body`) VALUES (:id, :type, :body)";
            $params = [
                ':id' => $event->getId(),
                ':type' => $event->getType(),
                ':body' => json_encode($event->getBody())
            ];
            $stmt = $this->pdo->getClient()->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function findByType(string $type): ?Event
    {
        $stmt = $this->pdo->getClient()->prepare("SELECT * FROM event WHERE `type` = ?");
        $stmt->execute([$type]);
        $eventArray = $stmt->fetch(PDO::FETCH_LAZY);

        if (empty($eventArray)) {
            return null;
        }

        $event = new Event();
        $event->setId((int) $eventArray['id']);
        $event->setType($eventArray['type']);
        $event->setBody(json_decode($eventArray['body']));

        return $event;
    }
}
