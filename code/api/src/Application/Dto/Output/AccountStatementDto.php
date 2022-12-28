<?php

declare(strict_types=1);

namespace App\Application\Dto\Output;

use App\Domain\Entity\AccountStatement;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

class AccountStatementDto
{
    /**
     * @Assert\Uuid()
     * @OA\Property(property="id", example="2cd99e31-c0c4-4b11-a7af-339fecb3cd60")
     */
    public ?Uuid $id = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(max="140")
     * @OA\Property(property="text", example="Выписка по счету (Маша) за период с 11.06.2018 по 07.12.2022")
     */
    public ?string $text = null;

    public ?bool $cache = null;
}