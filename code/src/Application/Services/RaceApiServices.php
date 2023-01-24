<?php

namespace Otus\Mvc\Application\Services;

use Otus\Mvc\Application\Models\Entity\Races;
use Otus\Mvc\Application\Models\Entity\Producer\ApiQueue;

class RaceApiServices
{
    public static function allRacesApiServ()
    {
        header("Content-Type: application/json; charset=UTF-8");
        $array_races = Races::allRaces();

        if ($array_races) {
            http_response_code(200);
            $result = json_encode($array_races, JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Races not found"
            ];
            $result = json_encode($not_found_result, JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }

    public static function getRacesApiIdServ($race_id)
    {
        header("Content-Type: application/json; charset=UTF-8");
        $array_info_race = Races::getRaceID($race_id);

        if ($array_info_race) {
            http_response_code(200);
            $result = json_encode($array_info_race, JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Race not found"
            ];
            $result = json_encode($not_found_result, JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }

    public static function saveRaceApiServ($user_data)
    {
        header("Content-Type: application/json; charset=UTF-8");
        $race_name = $user_data['race_name'];
        $new_race = Races::saveRace($race_name);

        if ($new_race) {
            new ApiQueue($new_race);
            http_response_code(201);
            $save_result = [
                "status" => true,
                "message" => "Race created",
                "id" => $new_race
            ];
            $result = json_encode($save_result,JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_save_result = [
                "status" => false,
                "message" => "Race not save"
            ];
            $result = json_encode($not_save_result,JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }
}