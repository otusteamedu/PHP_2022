<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Model;

class EventModel
{
    /**
     * @param $param
     * @return mixed
     */
    public function prepareParam($param): mixed
    {
        $arParam = explode("\n", $param);

        array_walk($arParam, function ($param) use (&$request){
            $tmp = explode("=", $param);
            $request[$tmp[0]] = $tmp[1];
        });

        return $request;
    }
}