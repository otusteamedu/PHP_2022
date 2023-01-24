<?php

namespace Otus\Mvc\Application\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Exception;
use Otus\Mvc\Application\Viewer\View;

class RaceRepo extends Model
{
    public $timestamps = false;

    public static function create()
    {
        if (!empty($_POST['race_name']) &&
            !empty($_POST['race_date_start']) &&
            !empty($_POST['race_date_finish']) &&
            !empty($_POST['race_place']) &&
            !empty($_POST['race_description']) && 
            !empty($_POST['race_type_id']) &&
            (isset($_FILES['race_logo']) && $_FILES['race_logo']['size'] > 0)) {
                $secure_race_name = htmlspecialchars($_POST['race_name']);
                $secure_race_place = htmlspecialchars($_POST['race_place']);
                $secure_race_description = htmlspecialchars($_POST['race_description']);
                $secure_race_type_id = htmlspecialchars($_POST['race_type_id']);

                $allowedExtensions = ['jpg','jpeg','png'];
                $ext = pathinfo($_FILES['race_logo']['name'], PATHINFO_EXTENSION);
                if (in_array($ext, $allowedExtensions)) {
                    $uniq_name = uniqid().$_FILES['race_logo']['name'];
                    //$min_uniq_name = 'min-'.$uniq_name;
                    if (!getimagesize($_FILES['race_logo']['tmp_name'])) {
                        echo '<p class="error">Некорректный файл!</p>';
                    }
                    if (!move_uploaded_file($_FILES['race_logo']['tmp_name'],'../Assets/img/logo_race/'.$uniq_name)) {
                        unset($uniq_name);
                    }
                }
                $race = new Race();
                $race->race_name = $secure_race_name;
                $race->race_place = $secure_race_place;
                $race->race_date_start = $_POST['race_date_start'];
                $race->race_date_finish = $_POST['race_date_finish'];
                $race->race_description = $secure_race_description;
                $race->race_type_id = $secure_race_type_id;
                $race->race_logo = $uniq_name;
                try {
                    if (!$race->save()) {
                        throw new Exception("Гонка не сохранилась в базе"); 
                    }
                } catch(\Exception $ex) {
                    MyLogger::log_db_error();
                    View::render('error',[
                        'title' => '503 - Service Unavailable',
                        'error_code' => '503 - Service Unavailable',
                        'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
                    ]);
                }
                return true;
        } else {
            return false;
        }
    }

    public static function del() 
    {
        $massif_races=[];
        $k=0;
        if (!empty($_GET['race_id'])) {
            $race_id = $_GET['race_id'];
            if ((Race::where('race_id', '=', $race_id)->delete())) {
                foreach (Race::all() as $races) {
                    $massif_races[$k]=[
                        "race_id" => $races['race_id'],
                        "race_name" => $races['race_name']
                    ];
                    $k++;
                }
                return $massif_races; 
            } else {
                return false;
            }
        }
    }
}
