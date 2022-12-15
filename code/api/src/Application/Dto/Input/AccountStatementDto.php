<?php

declare(strict_types=1);

namespace App\Application\Dto\Input;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class AccountStatementDto
{
    public ?Uuid $id = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $name = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min="10", max="10")
     */
    public ?string $dateBeginning = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min="10", max="10")
     */
    public ?string $dateEnding = null;

    public static function createFromQueue(string $messageBody): self
    {
        $message = json_decode($messageBody, true, 512, JSON_THROW_ON_ERROR);

        $result = new self();
        $result->id = Uuid::fromString($message['id']);
        $result->name = $message['name'];
        $result->dateBeginning = $message['dateBeginning'];
        $result->dateEnding = $message['dateEnding'];

        return $result;
    }
}