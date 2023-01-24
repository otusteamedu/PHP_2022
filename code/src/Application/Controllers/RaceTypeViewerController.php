<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\RaceTypeService;

class RaceTypeViewerController
{
    public function viewAllRaceTypes()
    {
        RaceTypeService::viewAllRaceTypeServ();   
    }
}



