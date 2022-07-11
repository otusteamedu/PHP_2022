<?php

namespace App\Mappers;

use App\Framework\IdentityMap;
use App\Models\Film;
use \PDO;
use \PDOStatement;

class FilmMapper
{
    private PDO $pdo;
    private IdentityMap $identityMap;

    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    private array $logs = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->identityMap = new IdentityMap();

        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM films WHERE id = ?'
        );
        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM films'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO films (title, description, poster, premier_date) VALUES (:title, :description, :poster, :premier_date)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE films SET title = ?, description = ?, poster = ?, premier_date = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM films WHERE id = ?'
        );
    }

    public function findById(int $id): Film
    {
        if ($this->identityMap->hasId(Film::class, $id)) {
            return $this->identityMap->getById(Film::class, $id);
        }

        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        $film = new Film(
            $result['id'],
            $result['title'],
            $result['description'],
            \DateTime::createFromFormat('Y-m-d', $result['premier_date']),
            $result['poster'],
        );

        $this->identityMap->set($film);

        return $film;
    }


    /**
     * @return Film[]
     */
    public function getAll(): array
    {
        $result = [];

        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute([]);

        while($queryResult = $this->selectAllStatement->fetch()) {
            $film = new Film(
                $queryResult['id'],
                $queryResult['title'],
                $queryResult['description'],
                \DateTime::createFromFormat('Y-m-d', $queryResult['premier_date']),
                $queryResult['poster'],
            );

            $result[] = $film;

            $this->identityMap->set($film);
        }

        return $result;
    }


    public function insert(array $rawFilmData): ?Film
    {
        if ($rawFilmData['id'] && $this->identityMap->hasId(Film::class, $rawFilmData['id'])) {
            throw new \RuntimeException('Entity id is exist');
        }

        $this->insertStatement->execute([
            ':title' => $rawFilmData['title'],
            ':description' => $rawFilmData['description'],
            ':poster' => $rawFilmData['poster'],
            ':premier_date' => $rawFilmData['premier_date'],
        ]);

        $film = new Film(
            (int)$this->pdo->lastInsertId(),
            $rawFilmData['title'],
            $rawFilmData['description'],
            \DateTime::createFromFormat('Y-m-d', $rawFilmData['premier_date']),
            $rawFilmData['poster'],
        );

        $this->identityMap->set($film);

        return $film;
    }

    public function update(Film $film): bool
    {
        return $this->updateStatement->execute([
            $film->getTitle(),
            $film->getDescription(),
            $film->getPoster(),
            $film->getPremierDate(),
            $film->getId(),
        ]);
    }

    public function delete(Film $film): bool
    {
        $deleted = $this->deleteStatement->execute([$film->getId()]);

        if ($deleted) {
            $this->identityMap->remove($film);
        }

        return $deleted;
    }
}
