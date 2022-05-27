<?php

declare(strict_types=1);

namespace App\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;


abstract class BaseRequest
{
    public function validate() : void
    {
        $errors = $this->validator->validate($this);

        $messages = ['message' => 'validation_failed', 'errors' => []];

        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages);
            $response->send(); exit;
        }
    }
}