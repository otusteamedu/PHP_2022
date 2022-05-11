<?php

namespace App\Entity;

use App\Repository\YoutubeStatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 */
#[ORM\Entity(repositoryClass: YoutubeStatisticsRepository::class)]

class YoutubeStatistics
{
    /**
     * @var
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @var
     */
    #[ORM\Column(type: 'string')]
    private $url;

    /**
     * @var
     */
    #[ORM\Column(type: 'integer', name: 'liking')]
    private $like;

    /**
     * @var
     */
    #[ORM\Column(type: 'integer')]
    private $dislike;

    /**
     * @var
     */
    #[ORM\Column(type: 'datetime')]
    private $created;

    /**
     * @var
     */
    #[ORM\Column(type: 'datetime')]
    private $updated;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDislike(): ?int
    {
        return $this->dislike;
    }

    /**
     * @param int $dislike
     * @return $this
     */
    public function setDislike(int $dislike): self
    {
        $this->dislike = $dislike;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    /**
     * @param \DateTimeInterface $created
     * @return $this
     */
    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * @param mixed $like
     * @return YoutubeStatistics
     */
    public function setLike($like)
    {
        $this->like = $like;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @param \DateTimeInterface $updated
     * @return $this
     */
    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
