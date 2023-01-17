<?php

declare(strict_types=1);

namespace Sveta\Code;

final class App
{
    public const CUSTOM_SERVER = 'server';
    public const CUSTOM_CLIENT = 'client';

    /**
     * @throws \Exception
     */
    public function run(string $arg): void
    {
        if ($arg != self::CUSTOM_CLIENT && $arg !== self::CUSTOM_SERVER) {
            throw new \Exception('Invalid argument value.');
        }
        try {
            switch ($arg) {
                case self::CUSTOM_SERVER:
                    (new Server())->run();
                    break;
                case self::CUSTOM_CLIENT:
                    (new Client())->run();
                    break;
            }
        } catch (\Throwable $exception) {
            throw new \Exception('An error has occurred. ' . $exception->getMessage());
        }
    }
}
