<?php

use Widgets\Alert;

if (! function_exists('view'))
{
    /**
    *
     * @param  string  $view
     * @param  array  $data
     *
     * @void
     */
    function view($view, $data = [])
    {
        echo (new \Core\Base\View())->make($view, $data);
    }
}

if (! function_exists('session'))
{
    /**
     * @return \Core\Base\Session
     */
    function session()
    {
        return new \Core\Base\Session();
    }
}