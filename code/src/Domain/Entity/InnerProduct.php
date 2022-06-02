<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity;


use Webmozart\Assert\Assert;

class InnerProduct implements EntityInterface, InnerProductInterface
{
    public const TYPES = [
        self::CARROT,
        self::SALAD,
        self::ONION,
        self::PEPPER,
        self::CHEESE,
        self::MEAT,
    ];

    public const CARROT = 'carrot';
    public const SALAD = 'salad';
    public const ONION = 'onion';
    public const PEPPER = 'pepper';
    public const CHEESE = 'cheese';
    public const MEAT = 'meat';

    public const AMOUNT_TYPES = [
        self::NUMERIC,
        self::GRAM,
    ];

    public const NUMERIC = 'шт';
    public const GRAM = 'грам';

    public function __construct(
        public string $name,
        public string $type,
        public string $amountType,
        public int $amount,
    ) {
        Assert::inArray($this->type, self::TYPES, 'created type is not system base product type');
        Assert::inArray($this->amountType, self::AMOUNT_TYPES, 'created amount type is not system amount type');
    }
}