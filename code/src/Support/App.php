<?php

namespace Koptev\Support;

use Koptev\Exceptions\MethodNotAllowedException;
use Koptev\Exceptions\NotFoundException;
use Throwable;

class App
{
    /**
     * Run application.
     *
     * @return Response
     */
    public function run(): Response
    {
        $request = new Request();

        $request->route()->load();

        try {

            $action = $request->route()->getAction($request);

            if (!class_exists($action[0])) {
                throw new NotFoundException('Controller ' . $action[0] . ' doesnt exist.');
            }

            $controller = new $action[0];

            $functionName = $action[1];

            if (!method_exists($controller, $functionName)) {
                throw new NotFoundException('Method ' . $action[1] . ' in controller ' . $action[0] . ' doesnt exist.');
            }

            return $controller->$functionName($request);
        } catch (NotFoundException $e) {
            $response = new Response();

            $response->notFound($e);

            return $response;
        } catch (MethodNotAllowedException $e) {
            $response = new Response();

            $response->methodNotAllowed();

            return $response;
        } catch (Throwable $e) {
            $response = new Response();

            $response->serverError($e);

            return $response;
        }
    }
}
