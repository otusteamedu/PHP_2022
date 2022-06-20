<?php

declare(strict_types=1);

namespace Igor\Php2022;

class App
{
    const CLIENT = 'client';
    const SERVER = 'server';

    private ChatRunner $chat;

    public function __construct(string $whoAmI)
    {
        $unixSocketAddress = (new Settings())->get('socket');

        switch ($whoAmI) {
            case self::CLIENT:
                $this->chat = new ChatClientApp(new ChatClientUnixSocketTransport($unixSocketAddress));;
                break;
            case self::SERVER:
                $this->chat = new ChatServerApp(new ChatServerUnixSocketTransport($unixSocketAddress));;
                break;
            default:
                throw new \Exception('Bad input');
        }
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $this->chat->run();
    }
}
