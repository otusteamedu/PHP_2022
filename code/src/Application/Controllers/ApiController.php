<?php

namespace Otus\Mvc\Application\Controllers;

use Otus\Mvc\Application\Services\RaceApiServices;
use Otus\Mvc\Application\Viewer\View;

class ApiController
{
    public static function getAllRacesApi()
    {
        RaceApiServices::allRacesApiServ();
    }

    public static function getRacesApiId($race_id)
    {
        RaceApiServices::getRacesApiIdServ($race_id);
    }

    public static function saveRaceApi($user_data)
    {
        RaceApiServices::saveRaceApiServ($user_data);
    }

}