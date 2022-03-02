<?php

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