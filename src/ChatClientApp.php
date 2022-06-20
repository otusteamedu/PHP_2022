<?php
declare(strict_types=1);


namespace Igor\Php2022;

class ChatClientApp implements ChatRunner
{
    private ChatClientTransportInterface $transport;

    public function __construct(ChatClientTransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function run(): void
    {
        while (1) {
            echo ': ';
            $this->transport->sendMessage(fgets(STDIN));
            echo ">> {$this->transport->getReply()}\n";
        }
    }
}