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
            // SMTP сервера вашей почты
            $mail->Host = $array_mailer_config['mail']['hostname'];
            $mail->Username = $array_mailer_config['mail']['user'];
            $mail->Password = $array_mailer_config['mail']['password'];
            $mail->Port = $array_mailer_config['mail']['port'];
            $mail->SMTPSecure = 'ssl';

            // Адрес самой почты и имя отправителя
            $mail->setFrom($array_mailer_config['mail']['from_email'], 'Mailer');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Запрос на выписку получен';

            $responseText = View::renderStr('response', [
                'period' => 1,
            ]);

            $mail->msgHTML($responseText);

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
