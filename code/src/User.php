<?php

namespace Ppro\Hw5;

class User
{
    private static $_instance = null;
    private $visit;

    private function __construct()
    {
        session_start();
        $this->visit = $_SESSION['visit'] = !empty($_SESSION['visit']) ? (int)$_SESSION['visit'] + 1 : 1;
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new self();
        return self::$_instance;
    }

    /** Получение количества посещений
     * @return string
     */
    public function getVisit() :string
    {
        return $this->visit;
    }
}