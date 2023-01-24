<?php

namespace Otus\Mvc\Application\Core;

use Otus\Mvc\Application\Controllers\ApiController;

class ApiApp
{
    public function run() {

        $request_api = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $params = explode('/', trim($request_api, '/'));

        $type = $params[2];
        if (isset($params[3])) {
            $race_id = $params[3];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                if ($type === 'race') {
                    if (isset($race_id)) {
                        ApiController::getRacesApiId($race_id);
                    } else {
                        ApiController::getAllRacesApi();
                    }
                }
                break;
            case 'POST':
                if ($type === 'race') {
                    ApiController::saveRaceApi($_POST);
                }
                break;
        }
    }
}