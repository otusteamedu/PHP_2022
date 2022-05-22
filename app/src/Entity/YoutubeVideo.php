<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\YoutubeVideoRepository;

#[ORM\Entity(repositoryClass: YoutubeVideoRepository::class)]
class YoutubeVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $title;

    #[ORM\Column(type: Types::INTEGER)]
    private $viewCount;

    #[ORM\Column(type: Types::INTEGER)]
    private $likeCount;

    #[ORM\ManyToOne(targetEntity: YoutubeChannel::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(name: 'channel_id', unique: true, nullable: false, columnDefinition: 'VARCHAR(255)')]
    private $channel;

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel($channel): void
    {
        $this->channel = $channel;
    }

    public function getViewCount()
    {
        return $this->viewCount;
    }

    public function setViewCount($viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    public function getLikeCount()
    {
        return $this->likeCount;
    }

    public function setLikeCount($likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
