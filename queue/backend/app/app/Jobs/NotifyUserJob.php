<?php

namespace App\Jobs;

use App\Application\Actions\EmailMessage\SendTextEmailMessageAction;
use App\Application\Actions\TelegramMessage\SendTextTelegramMessageAction;
use App\Application\Contracts\TextMessageTransportInterface;
use App\Application\DTO\SendTextMessageRequest;
use Illuminate\Support\Facades\Log;

class NotifyUserJob extends Job
{
    private string $message;

    private string $channel;

    private string $receiverCredentials;

    public function __construct(string $message, string $channel, string $receiverCredentials)
    {
        $this->message = $message;
        $this->channel = $channel;
        $this->receiverCredentials = $receiverCredentials;
    }

    private function getTransport(): TextMessageTransportInterface
    {
        $transports = [
            'telegram' => SendTextTelegramMessageAction::class,
            'email' => SendTextEmailMessageAction::class
        ];

        return app()->make($transports[$this->channel]);
    }

    public function handle()
    {
        try {
            $transport = $this->getTransport();

            Log::debug(
                $transport->send(new SendTextMessageRequest(
                    $this->receiverCredentials,
                    $this->message
                ))
            );

        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
