<?php

namespace Otus\App\Application\Entity\Messenger;

use Otus\App\App;
use Otus\App\Application\Viewer\View;
use Otus\App\Domain\Models\Interface\MessengerInterface;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * SendMail class
 */
class MailMessenger implements MessengerInterface
{
    /**
     * Send notification email
     * @param string $email
     * @return void
     */
    public function send(string $email)
    {
        $array_mailer_config = App::getMailConfig();

        // Настройки PHPMailer
        $mail = new PHPMailer();
        try {
            $mail->IsSMTP();
            $mail->CharSet = "UTF-8";
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = 0;

            // Настройки вашей почты
            $mail->Host = $array_mailer_config['mail']['hostname']; // SMTP сервера вашей почты
            $mail->Username = $array_mailer_config['mail']['user'];
            $mail->Password = $array_mailer_config['mail']['password'];
            $mail->Port = $array_mailer_config['mail']['port'];
            $mail->SMTPSecure = 'ssl';

            // Получатель письма
            $mail->setFrom('PupkinIgor74@yandex.ru', 'Mailer'); // Адрес самой почты и имя отправителя
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Запрос на выписку получен';

            $mail->msgHTML("<html><body>
                    <h1>Здравствуйте!</h1>
                    <p>Запрос на выписку получен. Срок обработки заявки - 1 рабочий день.</p>
                    </html></body>");

            $mail->send();

        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Email сообщение не доставлено'
            ]);
        }
    }
}
