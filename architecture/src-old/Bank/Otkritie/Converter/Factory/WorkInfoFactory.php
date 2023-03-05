<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\BoolStringValue;
use App\Bank\Otkritie\DTO\EnterApplication\WorkInfo;
use App\Exception\InvalidValueException;
use Dvizh\BankBusDTO\NewBusCompany;

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
