<?php

namespace Ppro\Hw20\Entity;

class ProductDto implements DtoInterface
{
    public function __construct(private string $status = "", private array $finishedProduct = [])
    {
    }

    /**
     * @return array
     */
    public function getFinishedProduct(): array
    {
        return $this->finishedProduct;
    }

    /**
     * @param array $finishedProduct
     */
    public function setFinishedProduct(array $finishedProduct): void
    {
        $this->finishedProduct = $finishedProduct;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    private function getProductInfo(): array
    {
        return [
          'PRODUCT' => $this->finishedProduct,
        ];
    }

    public function getProductInfoJson()
    {
        return json_encode($this->getProductInfo());
    }

    public function utilize()
    {
        $this->finishedProduct = [];
    }

}