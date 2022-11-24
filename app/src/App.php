<?php

declare(strict_types=1);


namespace ATolmachev\MyApp;


use ATolmachev\MyApp\Base\HttpException;
use ATolmachev\MyApp\Controllers\ParenthesesCheckerController;

class App
{
    public array $components;

    public function __construct(array $config)
    {
        foreach ($config as $key => $component) {
            $this->components[$key] = new $component();
        }
    }

    public function run(): void
    {
        try {
            $response = (new ParenthesesCheckerController($this->components))->actionIndex();
        } catch (HttpException $e) {
            $this->components['response']->handleHttpError($e);
            exit();
        }
        $this->components['response']->reply($response);
    }
}