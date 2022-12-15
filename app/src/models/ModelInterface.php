<?php

namespace app\models;

interface ModelInterface {
    public function showHitsTable(array $hits):string;
}
