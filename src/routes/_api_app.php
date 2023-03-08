<?php

app()->register(name: 'api_task_repository', value: function () {
    return new \Models\ApiTasks();
});

app()->get(
    pattern: '/api/v1/task/{task_uuid}',
    handler: 'Api\ApiController@get'
);
