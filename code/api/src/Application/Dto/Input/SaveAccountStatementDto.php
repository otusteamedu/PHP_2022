<?php

declare(strict_types=1);

namespace App\Application\Dto\Input;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use OpenApi\Annotations as OA;

class SaveAccountStatementDto
{
    /**
     * @Assert\NotBlank()
     * @OA\Property(property="name", example="Иван")
     */
    public ?string $name = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min="10", max="10")
     * @JMS\SerializedName("dateBeginning")
     * @OA\Property(property="dateBeginning", example="01.01.2020")
     */
    public ?string $dateBeginning = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min="10", max="10")
     * @JMS\SerializedName("dateEnding")
     * @OA\Property(property="dateEnding", example="31.12.2020")
     */
    public ?string $dateEnding = null;

    /**
     * @Assert\Type("bool")
     * @JMS\SerializedName("isSync")
     */
    public bool $isSync = true;

    public static function createFromArray(array $message): self
    {
        $result = new self();
        $result->name = $message['name'];
        $result->dateBeginning = $message['dateBeginning'];
        $result->dateEnding = $message['dateEnding'];

        return $result;
    }
}