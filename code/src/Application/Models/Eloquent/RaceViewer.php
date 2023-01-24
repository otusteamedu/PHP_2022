<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Exception;
use Otus\Mvc\Application\Viewer\View;
use Illuminate\Database\Capsule\Manager as DB;

class RaceViewer extends Model
{
    public $timestamps = false;

    public static function allRaces()
    {
        $massif_races=[];
        $k=0;
        try {
            if((Race::all()->first()) == null) {
                throw new Exception("Таблица с гонками не доступна");
            }
        } catch (\Exception $e) {
            MyLogger::log_db_error();
            View::render('error',[
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
        foreach (Race::all() as $races) {
            $massif_races[$k]=[
                "race_id" => $races['race_id'],
                "race_name" => $races['race_name']
            ];
            $k++;
        }
        return $massif_races;
    }

    public static function allRacesType()
    {
        if(!empty($_GET['racetype_id'])) {
            $racetype_id = $_GET['racetype_id'];
            $massif_races=[];
            $k=0;
            try {
                foreach (Race::where('race_type_id', '=', $racetype_id)->get() as $races) {
                    $massif_races[$k]=[
                        "race_id" => $races['race_id'],
                        "race_name" => $races['race_name']
                    ];
                    $k++;
                }
                return $massif_races;
            } catch (\Exception $e) {
                MyLogger::log_db_error();
                View::render('error',[
                    'title' => '503 - Service Unavailable',
                    'error_code' => '503 - Service Unavailable',
                    'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                ]);
            }
        }

    }

    public static function personalRaces()
    {
        if(!empty($_SESSION['user_id'])) {
            $user = $_SESSION['user_id'];
            $massif_race_result=[];
            $k=0;
            try {
                foreach (DB::table('users')
                             ->join('race_results', 'users.user_id', '=', 'race_results.user_id')
                             ->join('races', 'race_results.race_id', '=', 'races.race_id')
                             ->where('users.user_id', '=', $user)
                             ->select('race_results.user_final_result', 'users.username','races.race_name', 'races.race_id')
                             ->get() as $race_result) {
                    $race_result_array = json_decode(json_encode($race_result));
                    $array = json_decode(json_encode($race_result_array), true);

                    $massif_race_result[$k]=[
                        "user_final_result" => $array['user_final_result'],
                        "race_name" => $array['race_name'],
                        "race_id" => $array['race_id'],
                        "username" => $array['username']
                    ];
                    $k++;
                }
                return $massif_race_result;
            } catch (\Exception $e) {
                MyLogger::log_db_error();
                View::render('error',[
                    'title' => '503 - Service Unavailable',
                    'error_code' => '503 - Service Unavailable',
                    'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                ]);
            }
        }
    }

    public static function infoRace()
    {
        if(!empty($_GET['race_id'])) {
            $race_id = $_GET['race_id'];
            try {
                if(!$massif_race_info = Race::where('race_id', '=', $race_id)->first()){
                    throw new Exception("Таблица с гонками не доступна");
                }
            } catch (\Exception $e) {
                MyLogger::log_db_error();
                View::render('error',[
                    'title' => '503 - Service Unavailable',
                    'error_code' => '503 - Service Unavailable',
                    'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                ]);
            }
            return $massif_race_info;
        } else {
            return false;
        }
    }

}