<?php

declare(strict_types=1);

namespace Ppro\Hw15\Repositories;

use Ppro\Hw15\Connection\PostgresqlConnection;
use Ppro\Hw15\Entity\ActiveRecord\Movie;
use Ppro\Hw15\Entity\DataMapper\SessionMapper;

class PostgresqlRepository implements RepositoryInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $this->pdo = PostgresqlConnection::connect();
        } catch (Exception $e) {
            throw new \Exception("Cannot connect to postgresql server:" . $e->getMessage());
        }
    }

    /** Возвращает массив полей Сеанса, добавляет поле slug на основе наименования фильма
     * @param int $id
     * @return array
     */
    public function findSession(int $id): array
    {
        $sessionMapper = new SessionMapper($this->pdo);
        $session = $sessionMapper->findById($id);
        $arSession = $session ? $session->getAll() : [];
        if(!empty($session)) {
            $arSession['movie_slug'] = $this->getMovieSlug((int)$session->getMovie());
        }
        return $arSession;
    }

    /** Возвращает транслитерацию наименования фильма
     * @param int $id
     * @return string
     */
    public function getMovieSlug(int $id): string
    {
        return Movie::getById($this->pdo,$id)->getMovieSlug();
    }

    /** Проверяет равенство объектов (тестирование IdentityMap)
     * @param int $id
     * @param bool $status
     * @return array
     */
    public function checkIdentityMapInMovieEntity(int $id, bool $status): array
    {
        $movie1 = Movie::getById($this->pdo,$id,$status);
        $movie2 = Movie::getById($this->pdo,$id,$status);
        $result['EQUALITY'] = $movie1 === $movie2;
        return $result;
    }
}