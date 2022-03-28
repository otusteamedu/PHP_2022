<?php

namespace KonstantinDmitrienko\App;

class RequestValidator
{
    public static function validate($request): void
    {
        if (!$request || !isset($request['youtube'])) {
            throw new \RuntimeException('Empty request or missing required youtube parameter');
        }
    }

    public static function checkChannelName($request): void
    {
        if (!$request || !isset($request['youtube']['name'])) {
            throw new \RuntimeException('Empty request or missing required channel name parameter');
        }
    }
}
