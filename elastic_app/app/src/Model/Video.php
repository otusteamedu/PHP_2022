<?php

namespace Elastic\App\Model;

class Video implements ElasticModel
{
    private const INDEX = 'video';

    private string $id;
    private string $name;
    private string $description;
    private string $time;
    private int $likeCount;
    private int $dislikeCount;
    private string $channelId;

    public static function create(): self
    {
        return new self();
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

    public function getTime(): string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): self
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    public function setDislikeCount(int $dislikeCount): self
    {
        $this->dislikeCount = $dislikeCount;
        return $this;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;
        return $this;
    }
    
    public function getIndex(): string
    {
        return self::INDEX;
    }

    public function setData(array $data): void
    {
        $this->name = (string)$data['name'];
        $this->description = (string)$data['description'];
        $this->time = (string)$data['time'];
        $this->likeCount = (int)$data['likeCount'];
        $this->dislikeCount = (int)$data['dislikeCount'];
        $this->channelId = (string)$data['channelId'];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'time' => $this->time,
            'likeCount' => $this->likeCount,
            'dislikeCount' => $this->dislikeCount,
            'channelId' => $this->channelId,
        ];
    }
}