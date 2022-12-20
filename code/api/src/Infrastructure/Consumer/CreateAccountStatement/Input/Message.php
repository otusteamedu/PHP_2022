<?php

declare(strict_types=1);

namespace App\Infrastructure\Consumer\CreateAccountStatement\Input;

use App\Application\Dto\Input\SaveAccountStatementDto;
use Symfony\Component\Uid\Uuid;

class Message
{
    /**
     * @Assert\Uuid()
     */
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

    public static function createFromDto(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): self
    {
        $result = new self();
        $result->id = $id;
        $result->name = $saveAccountStatementDto->name;
        $result->dateBeginning = $saveAccountStatementDto->dateBeginning;
        $result->dateEnding = $saveAccountStatementDto->dateEnding;

        return $result;
    }

    public function toAMQPMessage(): string
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}