<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Otus\Mvc\Application\Viewer\View;

class RaceType extends Model
{
    public $timestamps = false;

    public static function allRaceTypes() 
    {
        $massif_racetypes=[];
        $k=0;
        try {
            foreach (RaceType::all() as $racetypes) {
                $massif_racetypes[$k]=[
                    "type_id" => $racetypes['type_id'],
                    "type_name" => $racetypes['type_name']
                ];
                $k++;
            }
        } catch (\Exception $e) {
            MyLogger::log_db_error();
            View::render('error',[
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
        return $massif_racetypes;
    }

}

