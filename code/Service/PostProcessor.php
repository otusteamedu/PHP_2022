<?php

declare(strict_types=1);

namespace App\Service;

use App\Http\Response;
use Olelishna\EmailVerifier\Verifier;

class PostProcessor
{
    public function process(): Response
    {
        if (isset($_POST['emails']) && is_array($_POST['emails'])) {

            $verifier = new Verifier($_POST['emails']);

            $resultArray = $verifier->check();

            return new Response(json_encode($resultArray));
        }

        return new Response('No emails', Response::HTTP_BAD_REQUEST, ['content-type' => 'text/html']);
    }
}
