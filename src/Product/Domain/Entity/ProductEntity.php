<?php

namespace Otus\Task13\Product\Domain\Entity;

use Otus\Task13\Product\Domain\ValueObject\ProductDescription;
use Otus\Task13\Product\Domain\ValueObject\ProductId;
use Otus\Task13\Product\Domain\ValueObject\ProductTitle;

class ProductEntity
{

    public function __construct(
        private readonly ProductTitle       $title,
        private readonly ProductDescription $description,
        private readonly ?ProductId         $id = null,

    )
    {
    }


    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title->getValue();
    }

    public function getDescription(): ProductDescription
    {
        return $this->description;
    }
}