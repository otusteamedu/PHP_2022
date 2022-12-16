<?php

namespace app\controllers;

use app\components\Request;
use app\models\Event\EventModel;

class EventController {

    public function actionAdd() {
        $events = Request::post('events');

        if (!$events) throw new \Exception('Не получен объект события.', 400);

        $events = json_decode($events, true);

        $models = [];
        foreach ($events as $event) { // Если ошибка хоть в одной записи - не сохраняем ничего.
            $model = new EventModel($event);
            if (!$model->validate()) {
                throw new \Exception('Неверное событие: '.json_encode($event).PHP_EOL.var_export($model->errors, 1), 400);
            }
            $models[] = $model;
        }

        foreach ($models as $model) $model->save();

        return 'OK';
    }


    public function actionFind() {
        $conditions = Request::post('conditions');
        $conditions = json_decode($conditions, true);

        $model = new EventModel([]);
        $results = $model->findPriorityOne($conditions);

        header('Content-Type: application/json; charset=utf-8');
        return json_encode($results);
    }

    public function actionDelete_all() {
        $model = new EventModel([]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($model->deleteAll());
    }
}
