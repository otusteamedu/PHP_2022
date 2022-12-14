<?php

namespace Koptev\Controllers;

use Koptev\Support\Request;
use Koptev\Support\Response;
use Koptev\Support\Validator;

class VerificationController
{
    /**
     * Verify email.
     *
     * @return void
     */
    public function verifyEmail(Request $request): Response
    {
        $rules = [
            'email' =>[
                'required',
                'email',
            ],
        ];

        $validator = (new Validator())
            ->setData(['email' => $request->post('email')])
            ->setRules($rules);

        $response = new Response();

        if ($validator->validate()) {
            $response->ok();
        } else {
            $response->unprocessable(['errors' => $validator->errors()]);
        }

        return $response;
    }
}
