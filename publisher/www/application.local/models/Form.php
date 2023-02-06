<?php

namespace app\models;

class Form {
    private $do_action;

    public function loadPOSTData() {
        $this->do_action = $_POST['do_action'];
    }

}
