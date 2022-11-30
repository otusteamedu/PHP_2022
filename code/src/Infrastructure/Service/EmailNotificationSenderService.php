<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

use PHPMailer\PHPMailer\PHPMailer;

class EmailNotificationSenderService implements NotificationSenderInterface
{
    public function __construct(private PHPMailer $mailer) {}

    public function send(array $messageBody): bool
    {
        try {
            $this->mailer->addAddress('joe@example.net', 'Joe User');
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Выписка (' . $messageBody['name'] . ')';
            $this->mailer->Body    = 'Выписка с ' . substr($messageBody['dateBeginning']['date'], 0, 10) .
                ' по ' . substr($messageBody['dateEnding']['date'], 0, 10) . ' (' . $messageBody['name'] . ')';

            $this->mailer->send();
            echo PHP_EOL . 'Сообщение успешно обработано, выписка отправлена на e-mail' . PHP_EOL;

            return true;
        } catch (\Exception $exception) {
            echo PHP_EOL . 'Сообщение не обработано, ошибка при отправки выписки на e-mail' . PHP_EOL;
            return false;
        }
    }
}