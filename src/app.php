<?php

include('../vendor/autoload.php');

use ERazdorova\OtusUserDataPackage\Processor\UserDataProcessor;

$userData = new UserDataProcessor('Алесандрович', '01.09.1989');

printf("Пол: %s\n", $userData->getGender() ?? '<не определен>');
printf("Возраст: %s\n", $userData->getAge() ?? '<не определен>');
printf("Возрастная категория (согласно ВОЗ): %s\n", $userData->getAgeGrade() ?? '<не определена>');

$userData->setPatronymic('Алесандровна')->setGender();
printf("Пол сменен на: %s\n", $userData->getGender() ?? '<не определен>');
