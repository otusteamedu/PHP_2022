<?php

declare(strict_types=1);

namespace App\Infrastructure\Requests;

use App\Infrastructure\Response\ResponseFailed;

abstract class BaseRequest
{
    public function validate() : void
    {
        $errors = $this->validator->validate($this);
        $messages = [];

        foreach ($errors as $message) {
            $messages[] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages) > 0) {
            $response = new ResponseFailed($messages);
            $response->send(); exit;
        }
    }
}