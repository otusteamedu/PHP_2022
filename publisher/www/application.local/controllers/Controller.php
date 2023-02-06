<?php
namespace app\controllers;

use app\models\Form;
use app\views\View;

class Controller {
    public function run () {
        $model = new Form();
        var_dump($_POST['do_action']);
//        if (isset($_POST['emails']))  {
//            $model->loadPOSTData();
//            $model->validate();
//        }

        $view = new View();
        return $view->render();
    }
}
