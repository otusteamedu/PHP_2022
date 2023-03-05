<?php

declare(strict_types=1);

namespace App\Entity;

use App\NewLK\Enum\DealState;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(indexes={@Index(name="deal_history_deal_uuid_idx", columns={"deal_uuid"})})
 */
class DealHistory
{
    /**
     * Идентификатор документа
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private UuidInterface $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deal", inversedBy="history")
     * @ORM\JoinColumn(name="deal_uuid", referencedColumnName="internal_id", nullable=false)
     */
    private $deal;

    /**
     * Статус заявки
     *
     * @ORM\Column(type="string", enumType="App\NewLK\Enum\DealState")
     */
    private DealState $state;

    /**
     * Комментарий к статусу.
     *
     * @ORM\Column(type="text")
     */
    private string $comment;

    /**
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private \DateTimeImmutable $createdAt;

    public function __construct(Deal $deal, DealState $state, string $comment = '')
    {
        $this->deal = $deal;
        $this->state = $state;
        $this->comment = $comment;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getState(): DealState
    {
        return $this->state;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
