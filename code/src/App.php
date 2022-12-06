<?php

//use DataGenerator;
namespace Study\Cinema;

class App
{
    public function run()
    {
        $dt = new DataGenerator();
        $dt->InsertDataIntoSession();
    }

}