<?php

namespace Roman\Hw4;

class App
{

    /**
     * @return void
     */
    public function run():string
    {
        $check = new Check;
        return $check->run();
    }
}