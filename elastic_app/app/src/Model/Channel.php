<?php

namespace Elastic\App\Model;

use JetBrains\PhpStorm\ArrayShape;

class Channel implements ElasticModel
{
    private const INDEX = 'channel';

    private string $id;
    private string $name;
    private string $description;
    private int $subscribers;

    public static function create(): self
    {
        return new self();
    }

    public function getIndex(): string
    {
        return self::INDEX;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSubscribers(): int
    {
        return $this->subscribers;
    }

    public function setSubscribers(int $subscribers): self
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    public function setData(array $data): void
    {
        $this->name = (string)$data['name'];
        $this->description = (string)$data['description'];
        $this->subscribers = (int)$data['subscribers'];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'subscribers' => $this->subscribers,
        ];
    }
}