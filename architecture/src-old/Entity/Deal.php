<?php

declare(strict_types=1);

namespace App\Entity;

use App\NewLK\Enum\DealState;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(
 *     name="deals"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DealRepository")
 */
class Deal
{
    /**
     * Идентификатор сделки в нашей системе(newlk).
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     *
     * @var UuidInterface
     */
    private $internal_id;

    /**
     * Идентификатор сделки в банке, куда она была отправлена.
     *
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $external_id;

    /**
     * Идентификатор заявки из NewLK
     *
     * @ORM\Column(type="uuid")
     *
     * @var UuidInterface
     */
    private $application_uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bank", inversedBy="deals")
     * @ORM\JoinColumn(name="bank_internal_id", referencedColumnName="internal_id")
     *
     * @var Bank
     */
    private $bank;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * Статус заявки
     *
     * @ORM\Column(type="string", enumType="App\NewLK\Enum\DealState")
     * @Assert\NotNull(
     *     message="Статус сделки не должен быть NULL"
     * )
     *
     * @var DealState|null
     */
    private $state;

    /**
     * Комментарий
     *
     * @ORM\Column(type="text")
     *
     * @var ?string
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="deal", indexBy="internal_id")
     *
     * @var Collection<string, Document>
     */
    private $documents;

    /**
     * История изменения сделки
     *
     * @ORM\OneToMany(targetEntity="App\Entity\DealHistory", mappedBy="deal")
     */
    private Collection $history;

    /**
     * Данные, специфичные для сделок с Открытием
     *
     * @ORM\OneToOne(targetEntity="App\Entity\DealOtkritie", mappedBy="deal")
     * @var DealOtkritie|null
     */
    private $dealOtkritie;

    /**
     * Дата и время следующей проверки статуса сделки в банке
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=true)
     */
    private $nextCheckStatusDate;

    /**
     * Цифровой идентификатор заявки.
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $applicationSerial;

    /**
     * Анкета по сделке
     *
     * @ORM\Column(type="delivery_full_questionnaire", nullable=true)
     * @var DeliveryFullQuestionnaire|null
     */
    private $deliveryFullQuestionnaire;

    /**
     * ФИО главного заемщика
     *
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $borrowerFullName;

    public function __construct(UuidInterface $internal_id, UuidInterface $applicationUuid, Bank $bank)
    {
        $this->internal_id = $internal_id;
        $this->application_uuid = $applicationUuid;
        $this->bank = $bank;
        $this->documents = new ArrayCollection();
        $this->history = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getInternalId(): UuidInterface
    {
        return $this->internal_id;
    }

    public function setInternalId(string $internal_id): void
    {
        $this->internal_id = Uuid::fromString($internal_id);
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

    public function getState(): ?DealState
    {
        return $this->state;
    }

    /**
     * @psalm-internal App\Service\DealStateManager
     */
    public function setState(DealState $state): void
    {
        $this->state = $state;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return Collection<string, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function getHistory(): Collection
    {
        return $this->history;
    }

    public function getApplicationUuid(): UuidInterface
    {
        return $this->application_uuid;
    }

    public function setApplicationUuid(string $application_uuid): void
    {
        $this->application_uuid = Uuid::fromString($application_uuid);
    }

    public function getBank(): Bank
    {
        return $this->bank;
    }

    public function setBank(Bank $bank): void
    {
        $this->bank = $bank;
    }
    public function getNextCheckStatusDate(): ?\DateTimeImmutable
    {
        return $this->nextCheckStatusDate;
    }
    public function setNextCheckStatusDate(?\DateTimeImmutable $nextCheckStatusDate): void
    {
        $this->nextCheckStatusDate = $nextCheckStatusDate;
    }

    public function getApplicationSerial(): ?int
    {
        return $this->applicationSerial;
    }

    public function setApplicationSerial(?int $applicationSerial): void
    {
        $this->applicationSerial = $applicationSerial;
    }

    public function getDeliveryFullQuestionnaire(): ?DeliveryFullQuestionnaire
    {
        return $this->deliveryFullQuestionnaire;
    }

    public function setDeliveryFullQuestionnaire(?DeliveryFullQuestionnaire $deliveryFullQuestionnaire): void
    {
        $this->deliveryFullQuestionnaire = $deliveryFullQuestionnaire;
    }

    public function getBorrowerFullName(): ?string
    {
        return $this->borrowerFullName;
    }

    public function setBorrowerFullName(?string $borrowerFullName): void
    {
        $this->borrowerFullName = $borrowerFullName;
    }

    public function getDealOtkritie(): ?DealOtkritie
    {
        return $this->dealOtkritie;
    }

    public function setDealOtkritie(?DealOtkritie $dealOtkritie): void
    {
        $this->dealOtkritie = $dealOtkritie;
    }
}
