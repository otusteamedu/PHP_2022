<?php

namespace Ppro\Hw27\Consumer\Services;

class BankMailer
{
    private array $requestBody = [];
    public function __construct(array $requestBody)
    {
        $this->requestBody = $requestBody;
    }
    public static function sendMailProcessing($msg)
    {
        echo PHP_EOL.'[x] Received '.$msg->body.PHP_EOL;
        $requestBody = json_decode($msg->body, true);

        //обработка
        $mailProcessing = new self($requestBody);
        $mailProcessing->requestProcessing();

        //отправка письма
        $mailProcessing->sendMail();
    }

    private function requestProcessing()
    {
        //... подготовка тела письма
        $this->requestBody['subject'] = "Bank Account status";
    }

    private function sendMail()
    {
//        mail($this->requestBody['email'], $this->requestBody['subject'], $this->requestBody['msg']);
        echo("Mail send: To ".$this->requestBody['email'].PHP_EOL);
    }
}