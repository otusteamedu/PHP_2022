<?php

namespace Mselyatin\Project15\src\datamapper\mappers;

use Mselyatin\Project15\src\common\interfaces\StorageInterface;
use Mselyatin\Project15\src\common\storages\DbStorage;
use Mselyatin\Project15\src\datamapper\abstracts\DataMapperAbstract;
use Mselyatin\Project15\src\datamapper\collections\IdentityCollection;
use Mselyatin\Project15\src\datamapper\identity\Car;
use Mselyatin\Project15\src\common\interfaces\IdentityInterface;
use DomainException;
use PDO;

/**
 * @property DbStorage $storage
 *
 * Class CarMapper
 * @package Mselyatin\Project15\src\datamapper\mappers
 */
class CarMapper extends DataMapperAbstract
{
    /**
     * @param int $id
     * @return IdentityInterface
     * @throws \Assert\AssertionFailedException
     */
    public function findById(int $id): IdentityInterface
    {
        $identity = $this->identityMap->get($id);

        if (!$identity) {
            $stm = $this->storage->pdo->prepare("SELECT * FROM car WHERE id = ?");
            $stm->bindValue(1, $id);
            $stm->execute();

            $row = $stm->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                throw new DomainException(
                    "Модель с id $id не найден"
                );
            }

            $identity = Car::createFromState($row);
            $this->identityMap->add($identity, $id);
        }

        return $identity;
    }

    /**
     * @param int $limit
     * @param int|null $offset
     * @return IdentityCollection
     * @throws \Assert\AssertionFailedException
     */
    public function all(
        int $limit = 100,
        ?int $offset = null
    ): IdentityCollection  {
        $collection = IdentityCollection::create();

        $stm = $this->storage->pdo->prepare("SELECT * FROM car LIMIT :limit OFFSET :offset");

        $stm->bindValue(':limit', $limit);
        $stm->bindValue(':offset', $offset);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $carIdentity = Car::createFromState($row);
            $collection->addItem($carIdentity);
        }

        return $collection;
    }

    public function save(IdentityInterface $identity): bool
    {
        // TODO: Implement save() method.
    }

    public function insert(IdentityInterface $identity): int
    {
        // TODO: Implement insert() method.
    }

    public function update(IdentityInterface $identity): bool
    {
        // TODO: Implement update() method.
    }

    public function delete(IdentityInterface $identity): bool
    {
        // TODO: Implement delete() method.
    }
}