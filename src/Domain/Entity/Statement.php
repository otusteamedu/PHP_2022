<?php

namespace App\Domain\Entity;

use App\Domain\Contract\HasQueueInterface;
use App\Domain\Enum\StatusEnum;
use App\Infrastructure\Repository\StatementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StatementRepository::class)]
class Statement implements HasQueueInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"CUSTOM")]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator(class:"doctrine.uuid_generator")]
    private ?Uuid $id = null;

    #[ORM\Column(type:'string', length: 255, enumType: StatusEnum::class)]
    private ?StatusEnum $status = null;


    public function __construct()
    {
        $this->setStatus(StatusEnum::WAITING);
    }


    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $enum): self
    {
        $this->status = $enum;

        return $this;
    }


    public function toAMPQMessage(): string
    {
        return json_encode(['statementId' => $this->id], JSON_THROW_ON_ERROR, 512);
    }
}
