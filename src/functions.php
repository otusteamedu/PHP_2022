<?php

function dd($value): never {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die;
}

function dump($value): void {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}