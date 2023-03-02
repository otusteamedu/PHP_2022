<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\NewBusCompany;
use App\Application\DTO\Bank\Otkritie\EnterApplication\BoolStringValue;
use App\Application\DTO\Bank\Otkritie\EnterApplication\WorkInfo;
use App\Application\Exception\InvalidValueException;

class WorkInfoFactory
{
    public static function createByNewBusCompany(NewBusCompany $company, bool $isMainCompany = false): WorkInfo
    {
        if (true === $isMainCompany) {
            $jobType = BoolStringValue::TRUE;
        } else {
            $jobType = BoolStringValue::FALSE;
        }

        if (is_null($company->personPosition) || is_null($company->experience)) {
            throw new InvalidValueException('Поля personPosition и experience должны быть заполнены!');
        }

        $workInfo =  new WorkInfo($jobType, $company->personPosition);
        $workInfo->Seniority = $company->experience;

        return $workInfo;
    }
}
