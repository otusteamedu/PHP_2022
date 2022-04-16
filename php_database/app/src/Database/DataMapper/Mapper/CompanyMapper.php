<?php

namespace App\Db\Database\DataMapper\Mapper;

use App\Db\Database\Connector;
use App\Db\Database\DataMapper\Entity\Company;
use WS\Utils\Collections\CollectionFactory;

class CompanyMapper
{
    private \PDO $pdo;

    public function __construct(Connector $connector)
    {
        $this->pdo = $connector::connect();
    }

    public function insert(Company $company): int
    {
        $prepare = $this->pdo->prepare('INSERT INTO company(name, address, phone, email) VALUES (?, ?, ?, ?)');

        $prepare->execute([
            $company->getName(),
            $company->getAddress(),
            $company->getPhone(),
            $company->getEmail(),
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update(Company $company): void
    {
        $prepare = $this->pdo->prepare('UPDATE company SET name=?, address=?, phone=?, email=? WHERE id=?');

        $prepare->execute([
            $company->getName(),
            $company->getAddress(),
            $company->getPhone(),
            $company->getEmail(),
            $company->getId(),
        ]);
    }

    public function delete(Company $company): void
    {
        $prepare = $this->pdo->prepare('DELETE FROM company WHERE id = ?');
        $prepare->execute([$company->getId()]);
    }

    public function findById(int $id): ?Company
    {
        $prepare = $this->pdo->prepare('SELECT id, name, address, phone, email FROM company WHERE id = ?');
        $prepare->execute([$id]);
        if (!$result = $prepare->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        }

        return Company::create()
            ->setId($result['id'])
            ->setName($result['name'])
            ->setAddress($result['address'])
            ->setPhone($result['phone'])
            ->setEmail($result['email']);
    }

    /**
     * @return Company[]
     */
    public function findAll(): array
    {
        $prepare = $this->pdo->query('SELECT id, name, address, phone, email FROM company', \PDO::FETCH_ASSOC);

        return CollectionFactory::fromIterable($prepare)
            ->stream()
            ->map(function (array $row) {
                return Company::create()
                    ->setId($row['id'])
                    ->setName($row['name'])
                    ->setAddress($row['address'])
                    ->setPhone($row['phone'])
                    ->setEmail($row['email']);
            })
            ->toArray();
    }
}
