<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Service\Http;


class Response
{
    public static function setResponseCode(int $httpStatus): int
    {
        return http_response_code($httpStatus);
    }
}