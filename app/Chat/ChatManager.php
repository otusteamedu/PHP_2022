<?php
declare(strict_types=1);

namespace Otus\Task07\App\Chat;

use Otus\Task07\Core\Application;
use Otus\Task07\Core\Socket\DomainSocket;

class ChatManager
{
    public function __construct(private Application $application){}

    public function make(string $type){

        $config = $this->application->getContainer('config');
        $domain = new DomainSocket($config['socket']);

        if($type === 'server'){
            return new ChatServerManager($domain);
        }
        if($type === 'client'){
            return new ChatClientManager($domain);
        }

    }

}


