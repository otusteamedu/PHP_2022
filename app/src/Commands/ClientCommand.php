<?php

namespace Nka\OtusSocketChat\Commands;

use Nka\OtusSocketChat\Services\SocketClientService;

class ClientCommand extends AbstractInvokeCommand
{
    public function __construct(
        protected SocketClientService $service
    )
    {}


    protected function run()
    {
        while (true) {
            echo PHP_EOL . 'Input something:' . PHP_EOL;
            $line = fgets(STDIN);
            $res = $this->service->write($line);

            echo PHP_EOL . 'Server result: ' . PHP_EOL;
            echo $res . PHP_EOL;

            if ($this->finish()) {
                break;
            }
        }
        echo 'Good bye!' . PHP_EOL;
    }

    private function finish(): bool
    {
        $decision = '';
        while ($decision !== 'y') {
            echo 'Continue? Y/n' . PHP_EOL;
            $decision = strtolower(trim(fgets(STDIN)));
            if ($decision === 'n') {
                return true;
            }
        }
        return false;
    }
}
