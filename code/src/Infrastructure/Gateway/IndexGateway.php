<?php

declare(strict_types=1);

namespace Svatel\Code\Gateway;

use Svatel\Code\Infrastructure\RequestStatus;

final class IndexGateway
{
    /**
     * @throws \HttpException
     */
    public static function run(): void
    {
        $requestStatus = new RequestStatus();
        $app = new ApiGateway($requestStatus);
        $app->run();
    }
}
