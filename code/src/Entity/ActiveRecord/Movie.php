<?php

namespace Ppro\Hw15\Entity\ActiveRecord;

use Ppro\Hw15\Entity\IdentityMap;

class Movie {
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $movie_id;
    private string $title;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select title from movie where movie_id = ?";

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
            "insert into movie (title) values (?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update movie set title = ? where movie_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from movie where movie_id = ?");
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->movie_id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): self
    {
        $this->movie_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }


    /**
     * @param \PDO $pdo
     * @param int $id
     * @param $withIdentityMap - подключение функционала IdentityMap
     * @return static
     */
    public static function getById(\PDO $pdo, int $id, $withIdentityMap = true): self
    {
        //IdentityMap
        //проверяем был ли запрошен объект раннее
        if ($withIdentityMap && $record = IdentityMap\ObjectWatcher::getRecord(self::class, $id)) {
            //получаем объект, запрошенный раннее
            $object = $record;
        } else {
            //создаем экземпляр класса на основе данных из базы
            $selectStmt = $pdo->prepare(self::$selectQuery);
            $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
            $selectStmt->execute([$id]);
            $result = $selectStmt->fetch();
            $object = (new self($pdo))
              ->setId($id)
              ->setTitle($result['title']);
            // добавляем объект в реестр
            IdentityMap\ObjectWatcher::addRecord($object, $id);
        }
        return $object;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->title
        ]);
        $this->movie_id = $this->pdo->lastInsertId();
        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->title,
            $this->movie_id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->movie_id;
        $this->movie_id = null;
        return $this->deleteStmt->execute([$id]);
    }


    /**  Возвращает транслитерацию наименования фильма
     * @return string
     */
    public function getMovieSlug(): string
    {
        $translit = "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();";
        $slug = transliterator_transliterate($translit, trim($this->title));
        return preg_replace('/[-\s]+/', '_', $slug);
    }
}