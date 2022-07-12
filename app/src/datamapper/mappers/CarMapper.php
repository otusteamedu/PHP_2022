<?php

namespace Mselyatin\Project15\src\datamapper\mappers;

use Mselyatin\Project15\src\common\interfaces\StorageInterface;
use Mselyatin\Project15\src\common\storages\DbStorage;
use Mselyatin\Project15\src\datamapper\abstracts\DataMapperAbstract;
use Mselyatin\Project15\src\datamapper\collections\IdentityCollection;
use Mselyatin\Project15\src\datamapper\identity\Car;
use Mselyatin\Project15\src\datamapper\interfaces\IdentityInterface;
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
     */
    public function findById(int $id): IdentityInterface
    {
        $stm = $this->storage->pdo->prepare("SELECT * FROM car WHERE id = ?");
        $stm->bindValue(1, $id);
        $stm->execute();

        $row = $stm->fetch(PDO::FETCH_ASSOC);
        return Car::createFromState($row);
    }

    /**
     * @return IdentityCollection
     */
    public function all(): IdentityCollection
    {
        $collection = IdentityCollection::create();

        $stm = $this->storage->pdo->query("SELECT * FROM car");
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