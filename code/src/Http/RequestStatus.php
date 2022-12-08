<?php

declare(strict_types=1);

namespace Sveta\Code\Http;

final class RequestStatus
{
    private const REQUEST = 'POST';

    public function checkPost(array $server): bool
    {
        if ($server['REQUEST_METHOD'] != self::REQUEST) {
            return false;
        }

        return true;
    }

    public function checkEmpty(array $data): bool
    {
        return !empty($data['string']);
    }
}
