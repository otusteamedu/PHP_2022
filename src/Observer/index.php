<?php

namespace Patterns\Observer;

require __DIR__ . '/../../vendor/autoload.php';

function clientCode() {
    $hh = new HeadHunter();
    $hh->addVacancy('PHP Junior Developer');
    $hh->addVacancy('PHP Middle Developer');

    $firstSubscriber = new Subscriber('Vasya');
    $secondSubscriber = new Subscriber('Petya');

    $hh->addObserver($firstSubscriber);
    $hh->addObserver($secondSubscriber);

    $hh->addVacancy('Senior PHP Developer');
}


clientCode();
