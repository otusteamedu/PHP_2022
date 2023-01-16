<?php

namespace Otus\App;

use Otus\App\Application\Controllers\ApiController;

class ApiApp
{
    public function run() {

        $request_api = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $params = explode('/', trim($request_api, '/'));

        $type = $params[2];
        if (isset($params[3])) {
            $enquiry_id = $params[3];
        }

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                if ($type === 'enquiry') {
                    if (isset($enquiry_id)) {
                        ApiController::getEnquiryId($enquiry_id);
                    } else {
                        ApiController::getAllEnquiries();
                    }
                }
                break;
            case 'POST':
                if ($type === 'enquiry') {
                    ApiController::saveEnquiry($_POST);
                }
                break;
        }
    }
}