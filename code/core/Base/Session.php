<?php

namespace Core\Base;

use Core\Widgets\Alert;

class Session
{
    /**
     * @var Alert $alert
     */
    protected Alert $alert;

    public function __construct()
    {
        $this->sessionStart();
        $this->alert = new Alert();
    }

    /**
     * @return void
     */
    private function sessionStart() :void
    {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * @return Alert
     */
    public function alertMessage() :Alert
    {
        return $this->alert;
    }
}