<?php
declare(strict_types=1);

namespace Qween\Php2022\Models;

use PDO;
use PDOStatement;

class Film
{
    private ?int         $film_id       = null;
    private ?string      $film_name     = null;
    private ?string      $description   = null;
    private ?int         $country_id    = null;
    private ?string      $premier_date  = null;
    private ?int         $genre_id      = null;
    private ?int         $producer_id   = null;
    private ?int         $scenario_id   = null;
    private ?int         $world_charges = null;
    private PDO          $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private array        $all;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM film WHERE film_id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO film (film_name, description, country_id, premier_date, genre_id, producer_id, scenario_id, world_charges) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE film SET film_name = :film_name, description = :description, country_id = :country_id,
                premier_date = :premier_date, genre_id = :genre_id, producer = :producer, scenario = :scenario_id,
                world_charges = :world_charges WHERE film_id = :film_id'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM film WHERE film_id = ?'
        );

        $this->all = $pdo->query("SELECT * FROM film")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    protected function instantiate($id): mixed
    {
        if (($record = IdentityMap::getRecord(
            get_class($this),
            $id
        ))) { // Пытаемся получить объект, если он уже был запрошен ранее
            $model = $record;
        } else { // иначе просто создаем экземпляр класса на основе данных из базы
            $model = new self($this->pdo);
            IdentityMap::addRecord($model, $id);// добавляем модель в реестр
        }
        return $model;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    /**
     * @param int|null $country_id
     *
     * @return Film
     */
    public function setCountryId(?int $country_id): Film
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPremierDate(): ?string
    {
        return $this->premier_date;
    }

    /**
     * @param string|null $premier_date
     *
     * @return Film
     */
    public function setPremierDate(?string $premier_date): Film
    {
        $this->premier_date = $premier_date;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGenreId(): ?int
    {
        return $this->genre_id;
    }

    /**
     * @param int|null $genre_id
     *
     * @return Film
     */
    public function setGenreId(?int $genre_id): Film
    {
        $this->genre_id = $genre_id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProducerId(): ?int
    {
        return $this->producer_id;
    }

    /**
     * @param int|null $producer_id
     *
     * @return Film
     */
    public function setProducerId(?int $producer_id): Film
    {
        $this->producer_id = $producer_id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getScenarioId(): ?int
    {
        return $this->scenario_id;
    }

    /**
     * @param int|null $scenario_id
     *
     * @return Film
     */
    public function setScenarioId(?int $scenario_id): Film
    {
        $this->scenario_id = $scenario_id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->film_id;
    }

    public function setId(int $id): self
    {
        $this->film_id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilmName(): ?string
    {
        return $this->film_name;
    }

    /**
     * @param string|null $film_name
     *
     * @return Film
     */
    public function setFilmName(?string $film_name): Film
    {
        $this->film_name = $film_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Film
     */
    public function setDescription(?string $description): Film
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWorldCharges(): ?int
    {
        return $this->world_charges;
    }

    /**
     * @param int|null $world_charges
     *
     * @return Film
     */
    public function setWorldCharges(?int $world_charges): Film
    {
        $this->world_charges = $world_charges;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function findOneById(int $id): self
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch(PDO::FETCH_ASSOC);

        return (new self($this->pdo))
            ->setId((int)$this->pdo->lastInsertId())
            ->setDescription($result['description'])
            ->setScenarioId($result['scenario_id'])
            ->setCountryId($result['country_id'])
            ->setFilmName($result['film_name'])
            ->setProducerId($result['producer_id'])
            ->setPremierDate($result['premier_date'])
            ->setGenreId($result['genre_id'])
            ->setWorldCharges($result['world_charges']);
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->film_name,
            $this->description,
            $this->country_id,
            $this->premier_date,
            $this->genre_id,
            $this->producer_id,
            $this->scenario_id,
            $this->world_charges
        ]);

        $this->film_id = (int)$this->pdo->lastInsertId();

        return $this->film_id;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function update(array $data): bool
    {
        return $this->updateStatement->execute($data);
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->all;
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStatement->execute([$id]);

        $this->film_id = null;

        return $result;
    }
}
