<?php
declare(strict_types=1);


namespace Igor\Php2022;

class ChatServerApp implements ChatRunner
{
    private ChatServerTransportInterface $transport;

    public function __construct(ChatServerTransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function run(): void
    {
        while (1) {
            $message = $this->transport->getMessage();
            echo ">> {$message}\n";
            $messageLength = strlen($message);
            $this->transport->sendMessage("Received ${messageLength} bytes");
        }
    }
}