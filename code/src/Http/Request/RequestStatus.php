<?php

declare(strict_types=1);

namespace src\Http\Request;

final class RequestStatus
{
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const GET = 'GET';
    private const DELETE = 'DELETE';

    public function checkMethod(array $server): bool
    {
        if (!in_array($server['REQUEST_METHOD'], self::list())) {
            return false;
        }

        return true;
    }

    public function checkEmpty(array $data): bool
    {
        return !empty($data['string']);
    }

    public static function list(): array
    {
        return [
            self::POST,
            self::GET,
            self::GET,
            self::DELETE
        ];
    }
}