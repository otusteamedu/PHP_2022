<?php

namespace AKhakhanova\Hw4;

class App
{
    public function run(array $parameters): void
    {
        if (!in_array('server', $parameters) && !in_array('client', $parameters)) {
            print_r('Invalid input parameters. Please choose one of the options "client" or "server"');
        }
        if (in_array('server', $parameters) && in_array('client', $parameters)) {
            print_r('Please choose only one of the options: "client" or "server"');
        }
        try {
            if (in_array('client', $parameters)) {
                (new Client())->run();
            }
            if (in_array('server', $parameters)) {
                (new Server())->run();
            }
        } catch (\Throwable $exception) {
            print_r('An error has occurred. ' . $exception->getMessage());

            return;
        }
    }
}
