<?php

declare(strict_types=1);

namespace Ekaterina\Hw5;

use Symfony\Component\Console\Application;
use Ekaterina\Hw5\Commands\EmailValidateCommand;
use Exception;

class App
{
    /**
     * @var Application консольное приложение
     */
    private Application $application;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->application = new Application();
        $this->application->add(new EmailValidateCommand());
    }

    /**
     * Запуск приложения
     *
     * @return void
     */
    public function run(): void
    {
        try {
            $this->application->run();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}