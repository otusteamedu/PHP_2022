<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\WorkPlaceList;
use Dvizh\BankBusDTO\NewBusPerson;
use Dvizh\BankBusDTO\Types\EmploymentStatus;

class WorkPlaceListFactory
{
    public static function createByNewBusPerson(NewBusPerson $person): WorkPlaceList
    {
        if ($person->employmentStatus->extract() === EmploymentStatus::SELF_EMPLOYED) {
            return new WorkPlaceList([WorkPlaceFactory::createForSelfEmployer($person)]);
        }

        $workPlaces = [];
        foreach ($person->company as $key => $company) {
            $isMainCompany = false;
            // Первую работу в списке считаем основной
            if (0 === $key) {
                $isMainCompany = true;
            }
            $workPlace = WorkPlaceFactory::createByNewBusCompany($company, $isMainCompany);
            $workPlaces[] = $workPlace;
        }

        return new WorkPlaceList($workPlaces);
    }
}
