<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity;


use Webmozart\Assert\Assert;

class BaseProduct implements EntityInterface, BaseProductInterface
{
    public const TYPES = [
        self::BURGER,
        self::SANDWICH,
        self::HOTDOG,
    ];

    public const BURGER = 'burger';
    public const SANDWICH = 'sandwich';
    public const HOTDOG = 'hotdog';

    public function __construct(
        public string $name,
        public string $type,
    ) {
        Assert::inArray($this->type, self::TYPES, 'created type is not base product type');
    }
}