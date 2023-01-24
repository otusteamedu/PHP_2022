<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\RaceService;

class RaceRepoController
{
    public function createdRace()
    {
        RaceService::createdRaceServ();   
    }

    public function delRace()
    {
        RaceService::delRaceServ();   
    }

    public function regOnRace()
    {
        RaceService::regOnRaceServ();
    }

}


