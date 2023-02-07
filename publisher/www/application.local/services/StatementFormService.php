<?php

namespace app\services;

use app\models\Form;
use app\models\ModelInterface;
use app\views\View;

class StatementFormService {
    private ModelInterface $formModel;

    public function __construct() {
        $this->formModel = new Form();
        $this->fillFormData();
    }


    public function getModel(): ModelInterface {
        return $this->formModel;
    }

    public function renderForm(): string {
        $view = new View();
        $model = $this->getModel();
        return $view->render($model->getErrors(), $model->dateFrom, $model->dateTo, $model->email);
    }

    private function fillFormData() {
        if ($this->formModel->loadPOSTData() && $this->formModel->validate())  {
            $this->formModel->publishMessage();
        }
    }
}
