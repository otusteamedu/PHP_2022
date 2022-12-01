<?php

namespace TemaGo\PostRequestValidator;

class App
{
    public function run() : void
    {
        $string = (new Request())->string;

        try {
            if (empty($string)) {
                throw new \ErrorException('Некорректный параметр');
            }

            (new Validator())->validate($string);

            Response::sendResponse('Параметр корректный');
        } catch (\ErrorException $e) {
            Response::sendResponse($e->getMessage(), 400);
        }
    }
}
