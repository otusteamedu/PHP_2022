<?php
declare(strict_types=1);


namespace App\Infrastructure;
use PDO;
use PDOStatement;

class ProductStorage implements \App\Application\Contracts\ProductStorageInterface
{
    protected PDO $pdo;
    protected PDOStatement $selectStatementById;
    protected PDOStatement $selectStatementByName;
    CONST TABLE_NAME = 'products';
    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatementById = $pdo->prepare(
            'SELECT * FROM {self::TABLE_NAME} WHERE id = ?'
        );
        $this->selectStatementByName = $pdo->prepare(
            'SELECT * FROM {self::TABLE_NAME} WHERE name LIKE ?'
        );
    }


    public function findById(int $productId)
    {
        $this->selectStatementById->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatementById->execute([$productId]);

        return $this->selectStatementById->fetch();
    }

    public function findByName(string $productName)
    {
        $this->selectStatementById->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatementByName->execute([$productName]);

        return $this->selectStatementByName->fetchAll();
    }
}