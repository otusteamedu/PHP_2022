<?php
declare(strict_types=1);

namespace App\Application\Contracts;

interface ProductStorageInterface
{
    public function findById(int $productId);
    public function findByName(string $productName);
}