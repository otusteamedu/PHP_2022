<?php

namespace app\services;

use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class StatementService
{
    private string $email;
    private string $dateFrom;
    private string $dateTo;

    public function __construct($dateFrom, $dateTo, $email) {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->email = $email;
    }

    public function create(): void {
        // изготовление выписки
    }

    public function sendNotice(): void {
        try {
            $mail = new Message();
            $mail->setFrom($_ENV['SMTP_FROM'])
                ->addTo($this->email)
                ->setSubject('Ваша выписка готова')
                ->setBody("Выписка готова, можете забирать.");

            $mailer = new SmtpMailer([
                'host' => $_ENV['SMTP_HOST'],
                'username' => $_ENV['SMTP_USERNAME'],
                'password' => $_ENV['SMTP_PASSWORD'],
                'secure' => 'ssl',
            ]);
            $mailer->send($mail);
        } catch (\Exception $e) {
            throw new \Exception('Не удалось отправить уведомление');
        }
    }
}
