<?php

namespace KonstantinDmitrienko\App;

use RuntimeException;

class RequestValidator
{
    /**
     * @param array $request
     *
     * @return void
     */
    public static function validate(array $request): void
    {
        if (!$request || !isset($request['youtube'])) {
            throw new RuntimeException('Empty request or missing required youtube parameter');
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public static function checkChannelName(string $name): void
    {
        if (!$name) {
            throw new RuntimeException('Missing required channel name parameter');
        }
    }
}
