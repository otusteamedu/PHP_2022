<?php

namespace App\Service;

class TelegramSender
{

    public function send(string $message): void
    {
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => 'https://api.telegram.org/bot' . $_ENV['TELEGRAM_TOKEN'] . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => [
                    'chat_id' => $_ENV['TELEGRAM_CHAT_ID'],
                    'text' => $message,
                ],
            ]
        );
        curl_exec($ch);
    }
}
