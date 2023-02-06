<?php
namespace app\controllers;

use app\models\Form;
use app\views\View;

class Controller {

    public function run (): string {
        $model = new Form();

        if ($model->loadPOSTData() && $model->validate())  {
            $model->publishMessage();
        }

        $errors = $model->getErrors();
        $view = new View();
        return $view->render($errors, $model->dateFrom, $model->dateTo, $model->email);
    }

}
