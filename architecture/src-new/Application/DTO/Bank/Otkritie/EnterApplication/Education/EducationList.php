<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Education;

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
