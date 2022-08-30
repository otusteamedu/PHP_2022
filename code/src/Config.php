<?php

namespace Rs\Rs;

class Config
{
    /**
     * @throws \Exception
     */
    public static function getConfig(): array
    {
       $file = parse_ini_file(getcwd().'/src/config/config.ini');
       if(!$file){
           throw new \Exception("Not found config".PHP_EOL);
       }
        return array($file['index'], $file['host']);
    }
}
