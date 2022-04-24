<?php

namespace App\Db\Database\DataMapper\Mapper;

use App\Db\Database\DataMapper\Entity\Company;
use App\Db\Database\QueryBuilder;
use WS\Utils\Collections\CollectionFactory;

class CompanyMapper
{
    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function insert(Company $company): int
    {
        return $this->queryBuilder
            ->table('company')
            ->insert($company);
    }

    public function update(Company $company): void
    {
        $this->queryBuilder
            ->table('company')
            ->update($company);
    }

    public function delete(Company $company): void
    {
        $this->queryBuilder
            ->table('company')
            ->delete($company);
    }

    public function findById(int $id): ?Company
    {
        $result = $this->queryBuilder
            ->select(['id', 'name', 'address', 'phone', 'email'])
            ->from('company')
            ->where('id = ' . $id)
            ->getQuery()
            ->getResult();

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
        $result = $this->queryBuilder
            ->select(['id', 'name', 'address', 'phone', 'email'])
            ->from('company')
            ->getQuery()
            ->getResult();

        return CollectionFactory::from($result)
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
