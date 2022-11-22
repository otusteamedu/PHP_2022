<?php
declare(strict_types=1);

namespace Otus\App\Viewer;

class Result
{
    public const EVENT_ADDED_MESSAGE        = 'Event successfully saved.';
    public const EVENT_NOT_ADDED_MESSAGE    = 'Error. Event is not saved.';
    public const EVENTS_DELETED_MESSAGE     = 'Events successfully removed.';
    public const EVENTS_NOT_DELETED_MESSAGE = 'Error. Events are not removed.';
    public const EVENT_NOT_FOUND_MESSAGE   = 'Error. Event is not found.';
    public const SUCCESS_STATUS             = 200;
    public const FAILURE_STATUS             = 400;
    public const JSON_HEADER_NAME           = 'content-type';
    public const JSON_HEADER_VALUE          = 'application/json';

    public static function failure(string $message = ''): void
    {
        self::failureResponseCode();
        self::showMessage($message);
    }

    public static function success(string $message = ''): void
    {
        self::successResponseCode();
        self::showMessage($message);
    }

    protected static function showMessage(string $message = ''): void
    {
        if ($message) {
            header(self::JSON_HEADER_NAME . ': ' . self::JSON_HEADER_VALUE);
            echo $message;
        }
    }

    protected static function failureResponseCode(): void
    {
        http_response_code(self::FAILURE_STATUS);
    }

    protected static function successResponseCode(): void
    {
        http_response_code(self::SUCCESS_STATUS);
    }
}
