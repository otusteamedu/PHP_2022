<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Информация об образовании.
 */
class EducationList
{
    public Education $Education;

    public function __construct(Education $Education)
    {
        $this->Education = $Education;
    }
}
