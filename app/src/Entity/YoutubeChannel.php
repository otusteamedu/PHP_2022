<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DBYoutubeChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'youtube_channels')]
#[ORM\Entity(repositoryClass: DBYoutubeChannelRepository::class)]
class YoutubeChannel
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    #[Assert\Type(Types::STRING)]
    private $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type(Types::STRING)]
    #[Assert\Length(min: 5, max: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'channel', targetEntity: YoutubeVideo::class, cascade: ['persist'])]
    private $videos;


    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }

    public function addVideo(YoutubeVideo $video): void
    {
        $video->setChannel($this);
        $this->videos->add($video);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
        ];
    }

    public static function createFromHttpYoutubeChannelDTO(
        HttpYoutubeChannelDTO $channelDTO
    ): self
    {
        $self = new self();
        $self->setId($channelDTO->getId());
        $self->setTitle($channelDTO->getTitle());
        return $self;
    }

    public static function createFromYoutubeChannelDTO(
        YoutubeChannelDTO $channelDTO
    ): self
    {
        $self = new self();
        $self->setId($channelDTO->getId());
        $self->setTitle($channelDTO->getTitle());
        return $self;
    }
}
