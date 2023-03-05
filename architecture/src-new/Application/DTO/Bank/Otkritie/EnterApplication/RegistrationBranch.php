<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

/**
 * ЦИК.
 */
class RegistrationBranch
{
    /**
     * ID доп. офиса
     */
    public string $BranchName;

    public function __construct(string $BranchName)
    {
        $this->BranchName = $BranchName;
    }
}
