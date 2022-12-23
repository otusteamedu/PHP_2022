<?php

use Src\Infrastructure\HttpRequest;
use Src\Application\EngineApplication;
use Src\Domain\Contracts\HttpGateway\HttpClient;
use Src\Application\Services\EmailHostnameExtractor;
use Src\Domain\Contracts\EmailHostnameExtractorContract;

use function DI\autowire;

return [
    'email_validator' => autowire(className: EngineApplication::class),
    EmailHostnameExtractorContract::class => autowire(className: EmailHostnameExtractor::class),
    HttpClient::class => autowire(className: HttpRequest::class),
];
