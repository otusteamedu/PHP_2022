<?php

$interface_implementaions = [
    'Core\Http\Contract\HttpRequestInterface' => 'Core\Http\HttpRequest',
    'Core\Http\Contract\HttpResponseInterface' => 'Core\Http\HttpResponse',
    'Core\Storage\Contract\StorageClientInterface' => 'Core\Storage\Mysql\Client',
    'App\User\Application\Contract\RepositoryInterface' => 'App\User\Infrastructure\Repository\Repository',
    'App\User\Application\Contract\GetUserServiceInterface' => 'App\User\Application\Service\GetUserService',
    'App\User\Application\Contract\CreateUserServiceInterface' => 'App\User\Application\Service\CreateUserService',
    'App\User\Application\Contract\UpdateUserServiceInterface' => 'App\User\Application\Service\UpdateUserService',
    'App\User\Application\Contract\DeleteUserServiceInterface' => 'App\User\Application\Service\DeleteUserService',
];
