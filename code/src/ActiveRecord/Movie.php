<?php

declare(strict_types = 1);

namespace Study\Cinema\ActiveRecord;

class Movie {
    /**
     * @var \PDO
     */
    private $pdo;

    private ?int $id;
    private string $name;
    private float $price;


    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select name, price  from movie where movie_id = ?";

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into movie(name, price, created_at, updated_at) values (?, ?, now(), now())"
        );
        $this->updateStmt = $pdo->prepare(
            "update movie set name = ?, price = ?, updated_at = now() where movie_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from movie where movie_id = ?");
    }


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Movie
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Movie
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }


    /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return Movie
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        return (new self($pdo))
            ->setId($id)
            ->setName($result['name'])
            ->setPrice($result['price']);

    }

    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->name,
            $this->price
        ]);
        $this->id = (int) $this->pdo->lastInsertId();
        return $result;
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->name,
            $this->price
        ]);
    }

    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;
        return $this->deleteStmt->execute([$id]);
    }

    public function business(): int
    {
        return (int) $this->price;
    }


}