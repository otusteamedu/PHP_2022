<?php

declare(strict_types=1);

namespace Controller;

use Core;

class ValidatorController
{
    private $response;

    private $request;

    public function __construct()
    {
        $this->response = new Core\Response();
        $this->request = new Core\Request();
    }

    public function go(): void
    {
        try {
            if (empty($this->request->post['string'])) {
                throw new \Exception("Request string is empty");
            }

            $validator = new Core\Validator();

            $is_match = $validator->validateBrackets($this->request->post['string']);

            if ($is_match) {
                $this->response->isOk();
            } else {
                throw new \Exception("Request string is wrong");
            }
        } catch (\Exception $ex) {
            $this->response->isBad($ex->getMessage());
        }
    }
}
