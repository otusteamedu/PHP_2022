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
            if (empty($this->request->post['email_list'])) {
                throw new \Exception("Email list is empty");
            }

            $validator = new Core\Validator();

            $error_list = [];

            foreach ($this->request->post['email_list'] as $email) {
                $is_valid = $validator->validateEmail($email);
                if (!$is_valid) {
                    $error_list[] = $email . ' is not valid.';
                }
            }

            if (!$error_list) {
                $this->response->isOk();
            } else {
                throw new \Exception(implode('<br>', $error_list));
            }
        } catch (\Exception $ex) {
            $this->response->isBad($ex->getMessage());
        }
    }
}
