<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(
 *     name="banks"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BankRepository")
 */
class Bank
{
    public const UUID_OTKRITIE = '00000000-0000-0000-0000-000000000000';
    public const NAME_OTKRITIE = 'Открытие';

    /**
     * Идентификатор банка в нашей системе(newlk).
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid", nullable=false)
     *
     * @var UuidInterface
     */
    private $internal_id;
    /**
     * Уникальный код банка
     * @ORM\Column(type="integer", options={"unsigned"=true}, unique=true, nullable=false)
     * @var int
     */
    private $external_id;

    /**
     * Наименование банка.
     *
     * @ORM\Column(type="string", length=250, nullable=false)
     * @var string
     */
    private $name;

    /**
     * Класс Message, который должен быть оправлен в SymfonyMessenger для обработки анкеты того или иного банка
     *
     * @ORM\Column(type="string", length=250, nullable=true)
     * @var string|null
     */
    private $initialMessage;
    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private $createdAt;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="bank")
     *
     * @var Collection<int, Deal>
     */
    private $deals;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    public function getInternalId(): UuidInterface
    {
        return $this->internal_id;
    }

    public function setInternalId(string $internal_id): void
    {
        $this->internal_id = Uuid::fromString($internal_id);
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getExternalId(): int
    {
        return $this->external_id;
    }

    public function setExternalId(int $external_id): void
    {
        $this->external_id = $external_id;
    }

    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function setDeals(Collection $deals): void
    {
        $this->deals = $deals;
    }

    public function getInitialMessage(): ?string
    {
        return $this->initialMessage;
    }

    public function setInitialMessage(string $initialMessage): void
    {
        $this->initialMessage = $initialMessage;
    }
}
