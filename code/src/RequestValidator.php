<?php

namespace KonstantinDmitrienko\App;

use RuntimeException;

class RequestValidator
{
    /**
     * @param $request
     *
     * @return void
     */
    public static function validate($request): void
    {
        if (!$request || !isset($request['youtube'])) {
            throw new RuntimeException('Empty request or missing required youtube parameter');
        }
    }

    /**
     * @param $name
     *
     * @return void
     */
    public static function checkChannelName($name): void
    {
        if (!$name) {
            throw new RuntimeException('Missing required channel name parameter');
        }
    }
}
