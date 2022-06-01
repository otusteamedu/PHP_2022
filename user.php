<?php

declare(strict_types=1);

namespace Budaev\ActiveRecord;

use PDO;
use PDOStatement;

// ActiveRecord
class User
{
    protected static $_instance;

    private ?int         $id          = null;

    private ?string      $firstName   = null;

    private ?string      $lastName    = null;

    private ?string      $passportId = null;

    private ?string      $adress      = null;

    private PDO          $pdo;

    private PDOStatement $selectStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );

        $this->selectManyStatement = $pdo->prepare(
            'SELECT * FROM categories WHERE `id` IN ($in)'
        );

        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (first_name, last_name, passportId, adress) VALUES (?, ?, ?, ?)'
        );

        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET first_name = ?, last_name = ?, passportId = ?, adress = ? WHERE id = ?'
        );

        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
    }

    public static function getInstance()  // Паттерн Lazy Load
    {
        if (null === static::$_instance) {            

            self::$_instance = new self;  // Загрузка первоначальных данных
        }
        return static::$_instance;
    }

    public function findOneById(int $id): self
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$this->pdo->lastInsertId())
            ->setFirstName($result['first_name'])
            ->setLastName($result['last_name'])
            ->setPassportId($result['passportId']);
            ->setAdress($result['adress']);
    }

    public function findManyById(array $array): self
    {
        $in  = str_repeat('?,', count($array) - 1) . '?';
        $this->selectManyStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectManyStatement->execute($array);
        $data = $this->selectManyStatement->fetchAll();
        
        return $data;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPassportId(): ?string
    {
        return $this->passportId;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setPassportId(?string $passportId): self
    {
        $this->passportId = $passportId;

        return $this;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->firstName,
            $this->lastName,
            $this->passportId,
            $this->adress,
        ]);

        $this->id = (int)$this->pdo->lastInsertId();

        return $this->id;
    }

    public function update(): bool
    {
        return $this->updateStatement->execute([
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->passportId,
            $this->id,
        ]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStatement->execute([$id]);

        $this->id = null;

        return $result;
    }

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
