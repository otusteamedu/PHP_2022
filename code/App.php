<?php

declare(strict_types=1);

namespace App;

use App\DataMapper\EventMapper;
use App\Entity\Event;
use App\Service\Config\ConfigReader;
use App\Utils\Connection;
use Exception;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    public function __construct()
    {
        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $connection = new Connection(
            $this->options['connection']['db_host'],
            $this->options['connection']['db_name'],
            $this->options['connection']['db_user'],
            $this->options['connection']['db_password']
        );

        $eventMapper = new EventMapper($connection);

        $event = new Event(
            null,
            '3 of September',
            '2022-09-03T00:00:00',
            '2022-09-03T23:59:59'
        );

        $eventMapper->insert($event);

        $event->setTimeEnd('2023-01-01T00:00:00');
        $eventMapper->update($event);

        $eventMapper->delete($event);

        $find1 = $eventMapper->findById(1);
        $find2 = $eventMapper->findById(1);

        $activeEvents1 = $eventMapper->findActiveEvents();
        $activeEvents2 = $eventMapper->findActiveEvents();
    }
}