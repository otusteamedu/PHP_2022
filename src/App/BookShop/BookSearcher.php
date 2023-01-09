<?php

declare(strict_types=1);

namespace App\App\BookShop;

use App\App\Elastic\RangeCondition;
use App\App\Elastic\RangeDTO;

class BookSearcher
{
    private ?string $category;
    private ?string $title;
    private ?RangeDTO $price;
    private ?RangeDTO $stock;

    public function __construct(private readonly BookShopRepository $repository)
    {
    }


    public function search()
    {
        $conditions = [];
        if (!\is_null($this->title)) {
            $conditions[] = $this->createMatchCondition('title', $this->title);
        }
        if (!\is_null($this->category)) {
            $conditions[] = $this->createMatchCondition('category', $this->category);
        }
        if (!\is_null($this->price)) {
            $conditions[] = $this->createRangeCondition('price', $this->price);
        }
        if (!\is_null($this->stock)) {
            $conditions[] = $this->createRangeCondition('stock.stock', $this->stock);
        }

        $query = [
            'bool' => [
                'must' => $conditions
            ]
        ];

        return $this->repository->search($query);
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $price строка вида {условие сравнения}_{значение}, например: gt_200, lte_100
     */
    public function setPrice(?string $price): void
    {
        if (\is_null($price)) {
            $this->price = null;
            return;
        }
        [$condition, $value] = \explode('_', $price);
        $this->price = new RangeDTO(RangeCondition::from($condition), $value);
    }

    /**
     * @param string|null $stock строка вида {условие сравнения}_{значение}, например: gt_200, lte_100
     */
    public function setStock(?string $stock): void
    {
        if (\is_null($stock)) {
            $this->stock = null;
            return;
        }
        [$condition, $value] = \explode('_', $stock);
        $this->stock = new RangeDTO(RangeCondition::from($condition), $value);
    }

    private function createMatchCondition(string $fieldName, mixed $fieldValue): array
    {
        return [
            'match' => [
                $fieldName => [
                    'query' => $fieldValue,
                    'fuzziness' => 'auto',
                ]
            ]
        ];
    }

    private function createRangeCondition(string $fieldName, RangeDTO $range): array
    {
        return [
            'range' => [
                $fieldName => [
                    $range->condition->value => $range->value
                ]
            ]
        ];
    }
}