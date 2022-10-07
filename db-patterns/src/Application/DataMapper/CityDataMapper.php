<?php

namespace AVasechkin\DataMapper\Application\DataMapper;

use AVasechkin\DataMapper\Domain\Models\City;
use AVasechkin\DataMapper\Domain\Models\CityCollection;
use PDO;

class CityDataMapper extends DataMapperPrototype
{
    public static function getTableName(): string
    {
        return 'city';
    }

    public function __construct(PDO $connection)
    {
        parent::__construct($connection);

        $this->selectStatement = $connection->prepare(
            sprintf('select * from %s where id = ?', self::getTableName())
        );

        $this->insertStatement = $connection->prepare(
            sprintf('insert into %s (name) values (?)', self::getTableName())
        );

        $this->updateStatement = $connection->prepare(
            sprintf('update %s set name = ? where id = ?', self::getTableName())
        );

        $this->deleteStatement = $connection->prepare(
            sprintf('delete from %s where id = ?', self::getTableName())
        );

        $this->findAllStatement = $connection->prepare(
            sprintf('select * from %s', self::getTableName())
        );
    }

    public function findOneById(int $id): ?City
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        if ($result === false) {
            return null;
        }

        return new City(
            $result['id'],
            $result['name']
        );
    }

    public function findAll(): CityCollection
    {
        $this->findAllStatement->execute();

        $collection = new CityCollection();

        foreach ($this->findAllStatement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collection->add(new City(
                $row['id'],
                $row['name']
            ));
        }

        return $collection;
    }

    public function update(City $city): bool
    {
        return $this->updateStatement->execute([
            $city->getName(),
            $city->getId()
        ]);
    }

    public function insert(City $city): ?City
    {
        if (!$this->insertStatement->execute([
            $city->getName()
        ])) {
            return null;
        }

        return $city->setId($this->pdo->lastInsertId());
    }

    public function delete(City $city): bool
    {
        return $this->deleteStatement->execute([$city->getId()]);
    }
}
