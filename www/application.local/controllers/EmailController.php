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
        $errors = implode("<br />", $model->getErrors());

        $view = new EmailView();
        echo $view->render($errors, $emails);
    }
}
