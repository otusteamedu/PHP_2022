<?php

namespace Roman\Hw4;

class App
{

    /**
     * @return void
     */
    public function run():void
    {
        $check = new Check;
        echo $check->run();
    }
}