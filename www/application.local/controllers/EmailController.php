<?php
namespace app\controllers;

use app\models\EmailForm;
use app\views\EmailView;

class EmailController {
    public function run () {
        $model = new EmailForm();
        if (isset($_POST['emails']))  {
            $model->loadPOSTData();
            $model->validate();
        }

        $emails = $_POST['emails'] ?? '';
        $errors = $model->getErrors();

        $view = new EmailView();
        return $view->render($errors, $emails);
    }
}
