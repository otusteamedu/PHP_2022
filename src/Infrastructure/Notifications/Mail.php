<?php

declare(strict_types=1);

namespace Src\Infrastructure\Notifications;

use PHPMailer\PHPMailer\{PHPMailer, Exception};

final class Mail
{
    /**
     * @var PHPMailer
     */
    private PHPMailer $mailer;

    /**
     * @var string
     */
    private string $recipient_email;

    /**
     * @var string
     */
    private string $recipient_name;

    /**
     * @var string
     */
    private string $email_subject;

    /**
     * @var string
     */
    private string $email_body;

    /**
     * @param string $recipient_email
     * @param string $recipient_name
     * @param string $email_subject
     * @param string $email_body
     * @return bool
     * @throws \Exception
     */
    public function notify(
        string $recipient_email,
        string $recipient_name,
        string $email_subject,
        string $email_body
    ): bool {
        $this->recipient_email = $recipient_email;
        $this->recipient_name = $recipient_name;
        $this->email_subject = $email_subject;
        $this->email_body = $email_body;

        try {
            $this->configurate()->prepareMail()->send();

            return true;
        } catch (\Exception $e) {
            throw new \Exception(message: "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return $this
     */
    private function configurate(): self
    {
        $this->mailer = new PHPMailer(exceptions: true);

        //Server settings

        //Send using SMTP
        $this->mailer->isSMTP();

        //Set the SMTP server to send through
        $this->mailer->Host = $_ENV['MAIL_HOST'];

        //Enable SMTP authentication
        $this->mailer->SMTPAuth = false;

        //SMTP username
        $this->mailer->Username = $_ENV['MAIL_USERNAME'];

        //SMTP password
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'];

        // 465 - TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $this->mailer->Port = $_ENV['MAIL_PORT'];

        $this->mailer->CharSet = 'UTF-8';

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    private function prepareMail(): self
    {
        // Recipients
        $this->mailer->setFrom(address: $_ENV['MAIL_FROM_ADDRESS'], name: $_ENV['APP_NAME']);

        // Add a recipient; Name is optional
        $this->mailer->addAddress(address: $this->recipient_email, name: $this->recipient_name);

        // Content
        $this->mailer->isHTML(isHtml: true); // Set email format to HTML
        $this->mailer->Subject = $this->email_subject;
        $this->mailer->Body = $this->email_body;

        return $this;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function send(): void
    {
        $this->mailer->send();
    }
}
