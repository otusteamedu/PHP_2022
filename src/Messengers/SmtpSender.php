<?php

namespace App\Messengers;

use App\Model\ConfigInterface;
use PHPMailer\PHPMailer\PHPMailer;

class SmtpSender implements \App\Model\SendMessageInterface
{
    protected $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }


    public function send(string $to, string $message, string $subject = "Simple bank report")
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = $this->config->get('smtp')['host'];
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Port = $this->config->get('smtp')['port'];
        $mail->Username = $this->config->get('smtp')['user'];
        $mail->Password = $this->config->get('smtp')['password'];

        $mail->setFrom($this->config->get('smtp')['sender']);
        $mail->addAddress($to);
        $mail->Subject = $subject;

        $mail->msgHTML("<html><body>
                <h1>Здравствуйте!</h1>
                <p>$message</p>
                </html></body>");

        $mail->send();
    }
}