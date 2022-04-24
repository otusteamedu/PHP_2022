<?php


namespace Decole\Hw15\Controllers;


class AppController extends AbstractController
{
    public function index($response)
    {
        try {
            $this->success($response, ['status' => 'ok']);
        } catch (\Throwable $exception) {
            $this->error($response, [$exception->getTrace()]);
        }
    }
}