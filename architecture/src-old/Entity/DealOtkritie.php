<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Специфичные данные для сделок в банк Открытие
 *
 * @ORM\Table(
 *     name="deals_otkritie"
 * )
 * @ORM\Entity
 */
class DealOtkritie
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="App\Entity\Deal", inversedBy="dealOtkritie")
     * @ORM\JoinColumn(name="deal_id", referencedColumnName="internal_id")
     *
     * @var Deal
     */
    private $deal;
    /**
     * Uuid сделки в Открытии
     *
     * @ORM\Column(type="uuid")
     *
     * @var UuidInterface
     */
    private $uuid;
    /**
     * Короткий идентификатор сделки в Открытии
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    private $shortId;

    public function __construct(Deal $deal, UuidInterface $uuid, int $shortId)
    {
        $this->deal = $deal;
        $this->uuid = $uuid;
        $this->shortId = $shortId;
    }

    public function getShortId(): int
    {
        return $this->shortId;
    }

    public function setShortId(int $shortId): void
    {
        $this->shortId = $shortId;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getDeal(): Deal
    {
        return $this->deal;
    }

    public function setDeal(Deal $deal): void
    {
        $this->deal = $deal;
    }
}
