<?php

namespace Otus\Mvc\Application\Services;

use Otus\Mvc\Application\Viewer\View;
use Otus\Mvc\Application\Models\Eloquent\RaceResult as EloquentRaceResult;
use Otus\Mvc\Application\Models\Eloquent\RaceViewer as EloquentRaceViewer;
use Otus\Mvc\Application\Models\Eloquent\RaceRepo as EloquentRaceRepo;
use Otus\Mvc\Application\Services\SendService;

class RaceService
{
    public static function allRacesServ()
    {
        $massif_races = EloquentRaceViewer::allRaces();
        if($massif_races !== null) {
            View::render('race',[
                'title' => 'Все гонки',
                'massif_races' => $massif_races
            ]);
        }        
    }

    public static function allRacesTypeServ()
    {
        $massif_races = EloquentRaceViewer::allRacesType();
        if($massif_races !== null) {
            View::render('race',[
                'title' => 'Гонки по виду спорта',
                'massif_races' => $massif_races
            ]);
        }  
    }

    public static function personalRacesServ()
    {
        $massif_race_result = EloquentRaceViewer::personalRaces();
        if($massif_race_result !== null) {
            View::render('racepers',[
                'title' => 'Ваши гонки',
                'massif_race_result' => $massif_race_result
            ]);
        }  else {
            View::render('error',[
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
    }

    public static function infoRaceServ()
    {
        $massif_race_info = EloquentRaceViewer::infoRace();
        $massif_race_results = EloquentRaceResult::allRaceResults();
        if ($massif_race_info !== null && $massif_race_results !== null) {
            $_SESSION['race_id'] = $massif_race_info['race_id'];
            View::render('raceinfo',[
                'title' => 'Информация по гонке',
                'race_id' => $massif_race_info['race_id'],
                'race_name' => $massif_race_info['race_name'],
                'race_description' => $massif_race_info['race_description'],
                'race_date_start' => $massif_race_info['race_date_start'],
                'race_date_finish' => $massif_race_info['race_date_finish'],
                'race_place' => $massif_race_info['race_place'],
                'race_logo' => $massif_race_info['race_logo'],
                'massif_race_results' => $massif_race_results
            ]);
        }     
    }

    public static function createdRaceServ()
    {
        if(EloquentRaceRepo::create()) {
            View::render('racenew',[
                        'title' => 'Новая гонка создана',
                        'race_id' => 'Присваивается',
                        'race_name' => $_POST['race_name']
            ]);
        } else {
            View::render('error',[
                'title' => '400 - Bad request',
                'error_code' => '400 - Bad request',
                'result' => 'Извините, мы не смогли создать гонку... попробуйте еще раз заполнить поля'
            ]);
        }
    }

    public static function delRaceServ()
    {
        if(EloquentRaceRepo::del()) {
            $massif_races = EloquentRaceViewer::allRaces();
            if($massif_races !== null) {
                View::render('race',[
                    'title' => 'Все гонки',
                    'massif_races' => $massif_races
                ]);
            }    
        } else {
            View::render('error',[
                'title' => 'Неудача',
                'result' => 'Извините, мы не смогли удалить гонку... попробуйте еще раз'
            ]);
        }
    }

    public static function regOnRaceServ()
    {
        if(EloquentRaceResult::raceRegistration()) {
                //TODO: уведомление отправить через почту, отправить сообщение в очередь
                $email_notification = new SendService();
                $email_notification->startSendMessage();
                $email = $_SESSION['email'];
                View::render('reg',[
                    'title' => 'Все гонки',
                    'result' => 'Успешная регистрация! Подробности вышлем на '.$email
                ]);
            }
        else {
            View::render('reg',[
                'title' => 'Все гонки',
                'result' => 'Вы уже ранее зарегистрировались на гонку'
            ]);
        }
    }
}