<?php

namespace Nka\OtusSocketChat\Commands;

use Nka\OtusSocketChat\Helpers\CliHelper;
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
            CliHelper::output('Input something:');

            $line = CliHelper::input();
            $res = $this->service->write($line);

            CliHelper::batchOutput([
                'Server result: ', $res
            ]);

            if ($this->finish()) {
                break;
            }
        }
        CliHelper::output('Good bye!');
    }

    private function finish(): bool
    {
        $decision = '';
        while ($decision !== 'y') {
            CliHelper::output('Continue? Y/n');
            $decision = strtolower(CliHelper::input());
            if ($decision === 'n') {
                return true;
            }
        }
        return false;
    }
}
