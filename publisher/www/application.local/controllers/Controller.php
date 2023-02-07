<?php
namespace app\controllers;

use app\services\StatementFormService;

class Controller {

    public function run (): string {
        $service = new StatementFormService();
        return $service->renderForm();
    }

}
