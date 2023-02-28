<?php

namespace App\Domain\Entity;

use JetBrains\PhpStorm\ArrayShape;

class Channel
{
    public const INDEX = 'youtube';
    public const TYPE = 'channel';

    public function __construct(
        private string $id,
        private string $title,
        private ?string $description = null,
        private int $likes = 0,
        private int $dislikes = 0,
    ) {}


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }


    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }


    public function getRating(): float
    {
        return $this->getLikes() / ($this->getDislikes() ?: 1);
    }


    #[ArrayShape(['id' => "string", 'title' => "string", 'description' => "null|string", 'likes' => "int", 'dislikes' => "int"])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'rating' => $this->getRating(),
        ];
    }
}
