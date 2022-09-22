<?php
declare(strict_types=1);

namespace App\Application;

use App\Application\Contracts\ProductStorageInterface;
use App\Domain\ValueObjects\Product;

class ProductMapper
{
    protected $db;
    protected $objectStorage = [];

    /**
     * @param $db
     */
    public function __construct(ProductStorageInterface $db)
    {
        $this->db = new $db;
    }

    public function getById(int $productId) : Product
    {
        //Записываем уже полученные данные
        if (!isset($this->objectStorage[$productId])) {
            $data = $this->db->findById($productId);
            $this->objectStorage[$productId] = new Product((int)$data['id'], $data['name'], (float) $data['price']);
        }

        return $this->objectStorage[$productId];
    }

    public function getByName(string $productName) : array
    {
        $dataList = $this->db->findByName($productName);
        $products = [];
        foreach ($dataList as $data) {
            $product = new Product($data['id'], $data['name'], $data['price']);
            $this->objectStorage[$product->getId()] = $product;
            $products[] = $product;
        }
        return $products;
    }
}