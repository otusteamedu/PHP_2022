<?php

function dd($value): never {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die;
}