<?php

declare(strict_types=1);

namespace Study\EmailValidator;

use Study\EmailValidator\Service\EmailValidator;
use Study\EmailValidator\Response\Response;

class App
{
    private EmailValidator $emailValidator;
    private Response $response;

    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
        $this->response = new Response();
    }

    public function run()
    {

        if (!isset( $_POST['emails'] )) {

            $this->response->setStatusCode( Response::HTTP_CODE_BAD_REQUEST, "Email не передан" );
            return $this->response->getResponse();
        } else {
            $emails = explode( ';', $_POST['emails'] );
        }

        $valid_emails = $this->emailValidator->validate( $emails );

        if (!empty( $valid_emails )) {
            $this->response->setStatusCode( Response::HTTP_CODE_OK, json_encode( $valid_emails ) );

        } else {
            $this->response->setStatusCode( Response::HTTP_CODE_BAD_REQUEST, "Нет корректных email." );

        }

        return $this->response->getResponse();

    }
}