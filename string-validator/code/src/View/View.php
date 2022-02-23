<?php

namespace KonstantinDmitrienko\StringValidator\View;

class View
{
    protected static string $viewDir = '';

    public function __construct()
    {
        self::$viewDir = $_SERVER['DOCUMENT_ROOT'] . '/view/';
    }

    public function showForm(): void
    {
        require self::$viewDir . 'components/form.php';
    }
}
