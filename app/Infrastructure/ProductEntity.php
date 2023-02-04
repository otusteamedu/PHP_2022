<?php
namespace Otus\Task12\App\Infrastructure;

use Otus\Task12\Core\ORM\Contract\EntityContract;
use Otus\Task12\Core\ORM\Mapping as Mapping;

#[Mapping\Table(name: 'products')]
#[Mapping\Entity(transform: ProductEntityTransform::class)]

class ProductEntity implements EntityContract
{
    #[Mapping\PrimaryKey('id')]
    public int|null $id = null;

    #[Mapping\Column('title')]
    public string $name;

    public function setId($id){
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}