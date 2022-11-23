<?php

namespace Koptev\Support;

use Koptev\Exceptions\NotFoundException;

class App
{
    /**
     * Run application.
     *
     * @return Response
     */
    public function run(): Response
    {
        Route::load();

        $request = new Request();

        try {

            $action = Route::getAction($request);

            $controller = new $action[0];

            $functionName = $action[1];

            return $controller->$functionName($request);
        } catch (NotFoundException $e) {
            $response = new Response();

            $response->notFound();

            return $response;
        }
    }
}
