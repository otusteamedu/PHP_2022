<?php

declare(strict_types = 1);

namespace App\Domain\ValueObjects;

class Status
{
    public const UNKNOWN = 1;
    public const ACTIVE = 1;
    public const INVALID = 2;
    public const INACTIVE = 3;
    public const UNSUBSCRIBED = 4;
    public const CLAIMED = 5;

    protected int $status;

    /**
     * @param int $status
     */
    public function __construct(int $status = self::UNKNOWN)
    {
        if (!in_array($status, [self::UNKNOWN, self::ACTIVE, self::INVALID, self::INACTIVE, self::UNSUBSCRIBED, self::CLAIMED]))
            throw new \InvalidArgumentException("Неверное значение статуса");
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->status;
    }




}