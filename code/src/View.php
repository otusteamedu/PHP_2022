<?php

namespace KonstantinDmitrienko\App;

class View
{
    /**
     * @var string
     */
    protected static string $viewDir = '';

    public function __construct()
    {
        self::$viewDir = $_SERVER['DOCUMENT_ROOT'] . '/view/';
    }

    /**
     * @return void
     */
    public function showForm(): void
    {
        require self::$viewDir . 'form.php';
    }
}
