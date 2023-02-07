<?php

namespace app\models;

use app\services\RabbitmqService;
use app\validators\DateValidator;
use app\validators\EmailValidator;
use PhpAmqpLib\Message\AMQPMessage;

class Form implements ModelInterface {
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $email = '';
    private array $errors = [];

    public function loadPOSTData(): bool {
        if (empty($_POST)) return false;
        $this->dateFrom = $_POST['dateFrom'];
        $this->dateTo = $_POST['dateTo'];
        $this->email = $_POST['email'];
        return true;
    }

    public function validate(): bool {
        $dates = [
            $this->dateFrom,
            $this->dateTo
        ];
        foreach ($dates as $date) {
            $validator = new DateValidator($date);
            if (!$validator->validate()) {
                $this->errors[] = $validator->getError();
            }
        }

        $this->checkDateDiff();

        $emailValidator = new EmailValidator($this->email);
        if (!$emailValidator->validate()) {
            $this->errors[] = $emailValidator->getError();
        }

        return empty($this->errors);
    }

    public function checkDateDiff(): void {
        $dateFrom = new \DateTime($this->dateFrom);
        $dateTo = new \DateTime($this->dateTo);
        $diff = $dateFrom->diff($dateTo)->format("%r%a");

        if ($diff < 0) $this->errors[] = 'Неправильно выбран временной интервал';
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function publishMessage(): void {
        $connection = (new RabbitmqService())->getConnection();
        $channel = $connection->channel();
        $channel->queue_declare('bank_statements', false, false, false, false);
        $msg = new AMQPMessage(serialize([
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'email' => $this->email,
        ]));
        $channel->basic_publish($msg, '', 'bank_statements');

        $channel->close();
        $connection->close();
    }

}
