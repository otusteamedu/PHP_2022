<?php

declare(strict_types=1);

namespace App;

use PDO;
use PdoFactory\PdoFactory;
use PDOStatement;

class UserTableGateway
{
    private PDO $pdo;

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     * @return UserTableGateway
     */
    public function setPdo(PDO $pdo): UserTableGateway
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * @return false|PDOStatement
     */
    public function getSelectStatement(): bool|PDOStatement
    {
        return $this->selectStatement;
    }

    /**
     * @param false|PDOStatement $selectStatement
     * @return UserTableGateway
     */
    public function setSelectStatement(bool|PDOStatement $selectStatement): UserTableGateway
    {
        $this->selectStatement = $selectStatement;
        return $this;
    }

    /**
     * @return false|PDOStatement
     */
    public function getInsertStatement(): bool|PDOStatement
    {
        return $this->insertStatement;
    }

    /**
     * @param false|PDOStatement $insertStatement
     * @return UserTableGateway
     */
    public function setInsertStatement(bool|PDOStatement $insertStatement): UserTableGateway
    {
        $this->insertStatement = $insertStatement;
        return $this;
    }

    /**
     * @return false|PDOStatement
     */
    public function getUpdateStatement(): bool|PDOStatement
    {
        return $this->updateStatement;
    }

    /**
     * @param false|PDOStatement $updateStatement
     * @return UserTableGateway
     */
    public function setUpdateStatement(bool|PDOStatement $updateStatement): UserTableGateway
    {
        $this->updateStatement = $updateStatement;
        return $this;
    }

    /**
     * @return false|PDOStatement
     */
    public function getDeleteStatement(): bool|PDOStatement
    {
        return $this->deleteStatement;
    }

    /**
     * @param false|PDOStatement $deleteStatement
     * @return UserTableGateway
     */
    public function setDeleteStatement(bool|PDOStatement $deleteStatement): UserTableGateway
    {
        $this->deleteStatement = $deleteStatement;
        return $this;
    }

    private PDOStatement $selectAll;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectAll = $pdo->prepare(
            'SELECT * FROM public.user'
        );
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM public.user WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO public.user (first_name, last_name, email) VALUES (?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE public.user SET first_name = ?, last_name = ?, email = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM public.user WHERE id = ?'
        );
    }

    public function getOneById(int $id): object
    {
        $this->selectStatement->execute([$id]);

        return $this->selectStatement->fetch(PDO::FETCH_OBJ);
    }

    public function getAll(): array
    {
        $this->selectAll->execute();

        return $this->selectAll->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert(
        string $firstName,
        string $lastName,
        string $email
    ): int
    {
        $this->insertStatement->execute([
            $firstName,
            $lastName,
            $email,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $firstName,
        string $lastName,
        string $email,
    ): bool
    {
        return $this->updateStatement->execute([
            $firstName,
            $lastName,
            $email,
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStatement->execute([$id]);
    }
}