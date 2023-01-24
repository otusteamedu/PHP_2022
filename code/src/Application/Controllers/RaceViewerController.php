<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\RaceService;
use Otus\Mvc\Application\Viewer\View;

class RaceViewerController
{
    public function allRaces()
    {
        RaceService::allRacesServ();   
    }

    public function allRacesType()
    {
        RaceService::allRacesTypeServ();   
    }
    
    public function personalRaces()
    {
        RaceService::personalRacesServ();   
    }

    public function infoRace()
    {
        RaceService::infoRaceServ();   
    }

    public function createRace(): View
    {

        View::render('raceCre',[
            'title' => 'Главная страница',
            'name' => 'Anonymous user',
        ]);
    }
}



    








