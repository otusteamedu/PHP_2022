<?php

namespace App\Entity;

use App\Entity\Trait\HasSearch;
use App\Repository\YoutubeStatisticsRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

/**
 * YoutubeStatistics
 */
#[ORM\Entity(repositoryClass: YoutubeStatisticsRepository::class)]

class YoutubeStatistics
{
    use HasSearch;

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

    /**
     * @return string
     */
    public function getTable(): string
    {
        return "youtube_statistics";
    }


    /**
     * @param array $ignores
     * @return array
     */
    #[ArrayShape(['id' => "int|null", 'url' => "null|string", 'like' => "mixed", 'dislike' => "int|null"])]
    public function convertToArray(array $ignores = []): array
    {
        $user = [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'like' => $this->getLike(),
            'dislike' => $this->getDislike(),
        ];

        // Remove key/value if its in the ignores list.
        for ($i = 0, $iMax = count($ignores); $i < $iMax; $i++) {
            if (array_key_exists($ignores[$i], $user)) {
                unset($user[$ignores[$i]]);
            }
        }

        return $user;
    }
}
