<?php

namespace Otus\Task13\Product\Infrastructure\Persistence\Entity;

use Otus\Task13\Core\ORM\Contract\EntityContract;
use Otus\Task13\Core\ORM\Mapping as Mapping;
use Otus\Task13\Product\Infrastructure\Persistence\Entity\Transform\ProductEntityTransform;

#[Mapping\Table(name: 'products')]
#[Mapping\Entity(transform: ProductEntityTransform::class)]
class ProductEntityPersistence implements EntityContract
{
    #[Mapping\PrimaryKey('id')]
    public int|null $id = null;

    #[Mapping\Column('title')]
    public ?string $name = null;

    #[Mapping\Column('description')]
    public ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}