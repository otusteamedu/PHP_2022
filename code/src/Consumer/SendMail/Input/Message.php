<?php

namespace App\Consumer\SendMail\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    public string $email;

    #[Assert\Type('string')]
    public string $subject;

    #[Assert\Type('string')]
    public string $text;

    public static function createFromQueue(string $messageBody): self
    {
        $message = json_decode($messageBody, true, 512, JSON_THROW_ON_ERROR);
        $result = new self();
        $result->email = $message['email'];
        $result->subject = $message['subject'];
        $result->text = $message['text'];

        return $result;
    }


    public function getText(): string
    {
        return $this->text;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
}