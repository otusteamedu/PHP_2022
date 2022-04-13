<?php


namespace Decole\Hw13\Controllers;


use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;

class EventController extends AbstractController
{
    public function index(Request $request, Response $response, ServiceProvider $service)
    {
        try {
            // https://github.com/klein/klein.php
    //        $service->validateParam('username', 'Please enter a valid username')->isLen(5, 64)->isChars('a-zA-Z0-9-');
            $service->validateParam('password')->notNull();
            $this->success($response, ['status' => 'success']);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }
}