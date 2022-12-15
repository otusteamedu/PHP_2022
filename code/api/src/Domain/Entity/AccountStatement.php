<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Table(name="account_statement")
 * @ORM\Entity(repositoryClass="App\Repository\TweetRepository")
 */
class AccountStatement
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid", unique=true)
     */
    private Uuid $id;

    /**
     * @ORM\Column(type="string", length=140, nullable=false)
     */
    private string $text;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setTextFromFields(string $name, string $dateBeginning, string $dateEnding): void
    {
        $this->text = 'Выписка по счету (' . $name . ') за период с ' .
            $dateBeginning . ' по ' . $dateEnding;
    }
}