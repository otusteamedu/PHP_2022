<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(
 *     name="profiles"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * Идентификатор профиля в нашей системе(newlk).
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $internal_id;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Deal")
     * @ORM\JoinColumn(name="deal_internal_id", referencedColumnName="internal_id")
     */
    private Deal $deal;

    /**
     * Автоинкерементное поле, используется, как идентификатор участников в некоторых банках.
     * Используется sequence=profiles_inc_id_seq
     * @ORM\Column(type="integer")
     */
    private int $incrementalId;

    /**
     * Идентификатор профиля в банке, куда была отправлена сделка.
     *
     * @ORM\Column(type="string")
     */
    private ?string $external_id = null;

    /**
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private \DateTimeImmutable $createdAt;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="profile", indexBy="internal_id")
     *
     * @var Collection<string, Document>
     */
    private Collection $documents;

    public function __construct(UuidInterface $internal_id, int $incrementalId, Deal $deal)
    {
        $this->documents = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->internal_id = $internal_id;
        $this->deal = $deal;
        $this->incrementalId = $incrementalId;
    }

    public function getInternalId(): UuidInterface
    {
        return $this->internal_id;
    }

    public function getDeal(): Deal
    {
        return $this->deal;
    }

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): void
    {
        $this->external_id = $external_id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Collection<string, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function getIncrementalId(): int
    {
        return $this->incrementalId;
    }
}
