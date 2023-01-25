<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Application\Mapper;

use DateTime;
use Dkozlov\Otus\Application\Interface\OperationMapperInterface;
use Dkozlov\Otus\Application\Interface\StorageInterface;
use Dkozlov\Otus\Domain\Operation;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
use Dkozlov\Otus\Exception\EntityNotFoundException;
use Exception;

class OperationMapper implements OperationMapperInterface
{
    protected string $table = 'operation';

    public function __construct(
        private readonly StorageInterface $storage,
        private readonly OperationIdentityMap $identityMap
    ) {
    }

    /**
     * @throws ConnectionTimeoutException
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function find(int $id): Operation
    {
        if ($this->identityMap->exist($id)) {
            return $this->identityMap->get($id);
        }

        $query = "SELECT * FROM {$this->table} WHERE id = :id";

        $response = $this->storage->select($query, ['id' => $id]);

        if (empty($response)) {
            throw new EntityNotFoundException("Operation with id = \"$id\" not found");
        }

        $operation = $this->buildOperation($response[0]);

        $this->identityMap->add($operation->getId(), $operation);

        return $operation;
    }

    /**
     * @throws ConnectionTimeoutException
     */
    public function save(Operation $operation): void
    {
        $query = "INSERT INTO {$this->table}(id, person, amount, date, created_at) VALUES (:id, :person, :amount, :date, :created_at)";

        $this->storage->insert($query, [
            'id' => $operation->getId(),
            'person' => $operation->getPerson(),
            'amount' => $operation->getAmount(),
            'date' => $operation->getDate()->format('Y-m-d H:i:s'),
            'created_at' => $operation->getCreatedAt()->format('Y-m-d H:i:s')
        ]);

        $this->identityMap->add($operation->getId(), $operation);
    }

    /**
     * @throws ConnectionTimeoutException
     */
    public function update(Operation $operation): void
    {
        $query = "UPDATE {$this->table} SET person = :person, amount = :amount, date = :date WHERE id = :id";

        $this->storage->insert($query, [
            'id' => $operation->getId(),
            'person' => $operation->getPerson(),
            'amount' => $operation->getAmount(),
            'date' => $operation->getDate()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @throws ConnectionTimeoutException
     */
    public function remove(string $id): void
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $this->storage->delete($query, ['id' => $id]);

        $this->identityMap->remove($id);
    }

    /**
     * @param string $user
     * @return Operation[]
     * @throws ConnectionTimeoutException
     * @throws Exception
     */
    public function getPersonOperations(string $person): array
    {
        $result = [];

        $query = "SELECT * FROM {$this->table} WHERE person = :person";
        $response = $this->storage->select($query, ['person' => $person]);

        foreach ($response as $item) {
            $operation = $this->buildOperation($item);

            $this->identityMap->add($operation->getId(), $operation);

            $result[] = $operation;
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function buildOperation(array $row): Operation
    {
        $date = new DateTime($row['date']);
        $createdAt = new DateTime($row['created_at']);

        return new Operation(
            $row['id'],
            $row['person'],
            (float) $row['amount'],
            $date,
            $createdAt
        );
    }
}