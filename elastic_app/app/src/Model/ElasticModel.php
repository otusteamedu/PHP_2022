<?php

namespace Elastic\App\Model;

interface ElasticModel
{
    public function getIndex(): string;
    public function getId(): string;
    public function setId(string $id): self;
    public function setData(array $data): void;
    public function toArray(): array;
    public static function create(): self;
}