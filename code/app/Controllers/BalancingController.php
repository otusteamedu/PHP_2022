<?php

namespace App\Controllers;

use Core\Base\WebController;

class BalancingController extends WebController
{
    /**
     * @return void
     */
    public function actionIndex() :void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $counter = $_SESSION['counter'] ?? 0;
        $counter++;
        $_SESSION['counter'] = $counter;

        $server = $_SERVER['HOSTNAME'];

        view('balancing', ['server' => $server, 'counter' => $counter]);
    }
}