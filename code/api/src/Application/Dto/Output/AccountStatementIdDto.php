<?php

declare(strict_types=1);

namespace App\Application\Dto\Output;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

class AccountStatementIdDto
{
    /**
     * @Assert\Uuid()
     * @OA\Property(property="id", example="2cd99e31-c0c4-4b11-a7af-339fecb3cd60")
     */
    public ?Uuid $id = null;

    public static function create(Uuid $id): self
    {
        $accountStatementIdDto = new self();
        $accountStatementIdDto->id = $id;

        return $accountStatementIdDto;
    }
}