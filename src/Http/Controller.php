<?php

namespace App\Http;

use App\Validator\Validator;

class Controller
{

    public function handle(): Response
    {
        $request = new Request();

        $string = trim($request->get('string'));

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
