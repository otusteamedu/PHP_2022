<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Образование.
 */
class Education
{
    // Образование (допустимые значения для Level)
    /** Среднее */
    public const LEVEL_SECONDARY = '100000003';
    /** Среднее специальное */
    public const LEVEL_SECONDARY_SPECIALIZED = '100000004';
    /** Неоконченное высшее */
    public const LEVEL_PARTIAL_HIGHER = '100000001';
    /** Высшее */
    public const LEVEL_HIGHER = '100000000';
    /** Два и более высших (в т.ч. MBA) */
    public const LEVEL_DOUBLE_HIGHER = '100000002';
    /** Ученая степень */
    public const LEVEL_DEGREED = '100000005';

    public string $Level;

    public function __construct(string $Level)
    {
        $this->Level = $Level;
    }
}
