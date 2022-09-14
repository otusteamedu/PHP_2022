<?php

namespace Mselyatin\Patterns\domain\valueObjects\bakery;

use Mselyatin\Patterns\domain\constants\BakeryTypesConstants;

class BakeryTypeValue
{
    /** @var int  */
    private int $type;

    private array $availableStatuses = [
        BakeryTypesConstants::BAKERY_BURGER_TYPE,
        BakeryTypesConstants::BAKERY_SANDWICH_TYPE,
        BakeryTypesConstants::BAKERY_HOT_DOG_TYPE
    ];

    /**
     * @param int|null $type
     */
    public function __construct(?int $type)
    {
        if (is_null($type)) {
            throw new \InvalidArgumentException(
                'Type must be exists'
            );
        }

        if (!in_array($type, $this->availableStatuses)) {
            throw new \InvalidArgumentException(
                "Type bakery $type not supported"
            );
        }
        
        $this->type = $type;
    }

    /**
     * @param int|null $type
     * @return static
     */
    public static function make(?int $type): self
    {
        return new self($type);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->type;
    }
}