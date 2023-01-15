<?php
namespace Otus\Task11\App\Services\Event;
use Otus\Task11\App\Services\Event\Contracts\DriverContract;
use Otus\Task11\App\Services\Event\Drivers\RedisDriver;

class EventManager
{
    private function __construct(private readonly DriverContract $driver){}

    public static function driver(string $driver): self{
        return match ($driver){
            'redis' => new self(new RedisDriver()),
            'default' => throw new \InvalidArgumentException(sprintf('Драйвер "%s" не найден', $driver)),
        };
    }
    public function send(Event $event){
        $this->driver->set($event);
    }

    public function get( array $condition){
        $event = $this->driver->get($condition);

        return $event;
    }

    public function clean(){
        $this->driver->clean();
    }
}