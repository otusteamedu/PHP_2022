<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $name;


    #[ORM\Column(type: 'string', nullable: true)]
    private string $url;

    #[ORM\ManyToOne(targetEntity: Status::class)]
    private mixed $status;

    #[ORM\Column(type: 'string')]
    private string $idQueque;

    /**
     * @return string
     */
    public function getIdQueque(): string
    {
        return $this->idQueque;
    }

    /**
     * @param string $idQueque
     * @return Report
     */
    public function setIdQueque(string $idQueque): Report
    {
        $this->idQueque = $idQueque;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Report
     */
    public function setName($name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Report
     */
    public function setUrl($url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Report
     */
    public function setStatus($status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}

