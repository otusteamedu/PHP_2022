<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure;

final class RequestStatus
{
    private const POST = 'POST';

    public function isPost(array $server): bool
    {
        return (bool) $server['REQUEST_METHOD'] == 'POST';
    }
}
