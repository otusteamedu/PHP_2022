<?php

namespace App\Http;

use App\Validator\Validator;

class Controller
{

    public function handle(Request $request): Response
    {
        $string = trim($request->post('string'));

        if (!$string || $string === '') {
            throw new \Exception('empty string');
        }

        $validator = new Validator();
        $result = $validator->validate($string);

        if (!$result) {
            throw new \Exception('Brackets is not valid');
        }

        return new Response('ok');
    }
}
