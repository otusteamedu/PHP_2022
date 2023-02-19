<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(
 *     name="documents"
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /** Общегражданский паспорт */
    public const TYPE_PASSPORT = 'passport';
    /** СНИЛС */
    public const TYPE_SNILS = 'snils';
    /** Справка 2-НДФЛ (или по форме банка) */
    public const TYPE_NDFL2_CERTIFICATE = '2ndfl-certificate';
    /** Пенсионное удостоверение */
    public const TYPE_PENSION_CERTIFICATE = 'pension-certificate';
    /** Трудовая книжка (трудовой договор) */
    public const TYPE_LABOUR_CONTRACT = 'labour-contract';
    /** Военный билет */
    public const TYPE_MILITARY_ID = 'military-id';
    /** Другое */
    public const TYPE_ANOTHER = 'another';
    /** Свидетельство о рождении */
    public const TYPE_BIRTH_CERTIFICATE = 'birth_certificate';
    /** Брачный договор */
    public const TYPE_MARRIAGE_CONTRACT = 'marriage_contract';
    /** Свидетельство о браке */
    public const TYPE_MARRIAGE_CERTIFICATE = 'marriage_certificate';
    /** Доверенность */
    public const TYPE_AGENT_POA_DOCUMENT = 'agent_poa_document';
    /** Устав компании */
    public const TYPE_COMPANY_CHARTER = 'company_charter';
    /** Приказ о назначении директора */
    public const TYPE_DIRECTOR_APPOINTMENT = 'director_appointment';
    /** Электронная подпись документа */
    public const TYPE_SIGNATURE = 'signature';
    /** Файл от банка */
    public const TYPE_BANK = 'bank';
    /** Скан анкеты клиента */
    public const TYPE_CREDIT_APP = 'credit-app';
    /** Сгенерированная анкета клиента с его электронной подписью */
    public const TYPE_AUTO_SIGNED_CREDIT_APP = 'auto_signed_credit_app';
    /** Загранпаспорт */
    public const TYPE_INTERNATIONAL_PASSPORT = 'international-passport';
    /** Предварительный Договор (Предварительный ДДУ) */
    public const TYPE_INITIAL_CONTRACT = 'initial-contract';
    /** Скан анкеты клиента Сбербанк России */
    public const TYPE_SBER_CREDIT_APP = 'sber-credit-app';
    /** Согласованный Договор (Согласованный ДДУ) */
    public const TYPE_AGREED_CONTRACT = 'agreed-contract';
    /** Зарегистрированный Договор (ДДУ с печатью Росреестра) */
    public const TYPE_STAMPED_CONTRACT = 'stamped-contract';
    /** Платежное поручение об открытии Аккредитива (Платежка) */
    public const TYPE_FINANCED_DOCUMENT = 'financed-document';

    /**
     * Идентификатор документа в нашей системе(newlk).
     *
     * @var UuidInterface
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private $internal_id;

    /**
     * Идентификатор документа в банке, куда он был отправлен.
     *
     * @var string|null
     * @ORM\Column(type="string")
     */
    private $external_id;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="datetimetz_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $originalFileName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $filePath;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $extension;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deal", inversedBy="documents")
     * @ORM\JoinColumn(name="deal_uuid", referencedColumnName="internal_id")
     *
     * @var Deal|null
     */
    private $deal;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="documents")
     *
     * @ORM\JoinColumns({
     *         @ORM\JoinColumn(name="profile_uuid", referencedColumnName="internal_id"),
     *         @ORM\JoinColumn(name="deal_uuid", referencedColumnName="deal_internal_id")
     *      })
     *
     * @var Profile|null
     */
    private $profile;
    /**
     * Размер файла в байтах.
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $size;
    /**
     * Комментарий
     *
     * @ORM\Column(type="text")
     *
     * @var ?string
     */
    private $comment;

    /**
     * Данные, специфичные для сделок с ГПБ
     *
     * @ORM\OneToOne(targetEntity="App\Entity\DocumentGPB", mappedBy="document")
     * @var DocumentGPB|null
     */
    private $documentGPB;

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

    public function setExternalId(?string $external_id): void
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
     * @return string
     */
    public function getOriginalFileName(): string
    {
        return $this->originalFileName;
    }

    /**
     * @param string $originalFileName
     */
    public function setOriginalFileName(string $originalFileName): void
    {
        $this->originalFileName = $originalFileName;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    public function getDeal(): ?Deal
    {
        return $this->deal;
    }

    public function setDeal(Deal $deal): void
    {
        $this->deal = $deal;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): void
    {
        $this->profile = $profile;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getDocumentGPB(): ?DocumentGPB
    {
        return $this->documentGPB;
    }

    public function setDocumentGPB(?DocumentGPB $documentGPB): void
    {
        $this->documentGPB = $documentGPB;
    }
}
