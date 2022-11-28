<?php

namespace Dmitry\App\Controllers;

use Dmitry\App\Core\Request;
use Dmitry\App\Core\Response;
use Dmitry\App\Helpers\StringHelper;

class HomeController
{

    public function index(): Response
    {
        if (isset($_SESSION['counter'])) {
            $_SESSION['counter']++;
        } else {
            $_SESSION['counter'] = 1;
        }

        ob_start();

        echo 'ID сессии: ' . session_id() . '<br>';
        echo 'Счетчик посещений: ' . $_SESSION['counter'] . '<br>';
        echo 'Контейнер: ' . $_SERVER['HOSTNAME'];

        return Response::make(ob_get_clean());
    }

    public function check(Request $request): Response
    {
        $stringHelper = StringHelper::getInstance();

        if ($stringHelper->validate($request->string ?: '')) {
            return Response::make('Все хорошо');
        } else {
            return Response::make('Все плохо')->withStatus(400);
        }
    }
}