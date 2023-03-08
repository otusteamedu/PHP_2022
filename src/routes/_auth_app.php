<?php

declare(strict_types=1);

app()->use(new \Middleware\Authentication\AuthControllerMiddleware());

app()->register(name: 'user_repository', value: function () {
    return new \Models\Users();
});

app()->post(
    pattern: '/api/v1/login',
    handler: 'Authentication\AuthController@login'
);
