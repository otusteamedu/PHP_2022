<?php

require_once "../vendor/autoload.php";

use Aldmarinka\NumWords\WordProcessor;

echo (new WordProcessor())->getNumWords(5, ['арбуз', 'арбуза', 'арбузов']);
