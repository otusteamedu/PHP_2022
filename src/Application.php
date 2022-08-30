<?php

namespace Mselyatin\Queue;

use Mselyatin\Queue\application\interfaces\QueueInterface;
use Mselyatin\Queue\application\valueObject\queue\QueueDataConnectionValueObject;
use \InvalidArgumentException;
use Mselyatin\Queue\infrastructure\controllers\http\FormController;

/**
 * @author Михаил Селятин <selyatin83@mail.ru>
 */
class Application
{
    /** @var Application|null $this  */
    public static ?self $app = null;

    /** @var QueueInterface  */
    private QueueInterface $queue;

    /** @var array  */
    private array $config = [];

    /**
     * Start application
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    public function run(array $config): void
    {
        if (static::$app === null) {
            $this->config = $config;
            $this->initQueueManager();
            static::$app = $this;
        }
    }

    private function initQueueManager(): void
    {
        try {
            $dataConnection = new QueueDataConnectionValueObject(
                $this->config['queue']['host'] ?? '',
                $this->config['queue']['port'] ?? '',
                $this->config['queue']['user'] ?? '',
                $this->config['queue']['password'] ?? '',
                $this->config['queue']['connection_timeout'] ?? 3.0,
                $this->config['queue']['connection_write'] ?? 3.0,
                $this->config['queue']['vhost'] ?? '/',
            );

            $classQueueManager = $this->config['queue']['class'] ?? null;
            if (class_exists($classQueueManager)) {
                $this->queue = new $classQueueManager($dataConnection);
                return;
            }

            throw new InvalidArgumentException(
                "Error! Class $classQueueManager not exists.",
            );

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getQueueManager(): QueueInterface
    {
        return $this->queue;
    }

    public function runFormProcessController(): void
    {
        $controller = new FormController();
        $controller->addBlankDetails();
    }
}