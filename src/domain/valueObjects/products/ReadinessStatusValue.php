<?php

namespace Mselyatin\Patterns\domain\valueObjects\products;

use Mselyatin\Patterns\domain\constants\ReadinessStatusConstants;

class ReadinessStatusValue
{
    /** @var string  */
    private string $status;

    private array $availableStatuses = [
        ReadinessStatusConstants::WAIT,
        ReadinessStatusConstants::COOKING,
        ReadinessStatusConstants::CREATED
    ];

    /**
     * @param string|null $status
     */
    public function __construct(?string $status)
    {
        if (is_null($status)) {
            throw new \InvalidArgumentException(
                'Status must be exists'
            );
        }

        if (!in_array($status, $this->availableStatuses)) {
            throw new \InvalidArgumentException(
                "Status bakery $status not supported"
            );
        }

        $this->status = $status;
    }

    /**
     * @param int|null $type
     * @return static
     */
    public static function make(?string $status): self
    {
        return new self($status);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->status;
    }
}