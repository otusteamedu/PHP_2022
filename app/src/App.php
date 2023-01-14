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

    public function run(): string
    {
        try {
            $response = (new ParenthesesCheckerController($this->components))->actionIndex();
            return $this->components['response']->reply($response);
        } catch (HttpException $e) {
            return $this->components['response']->handleHttpError($e);
        }
    }
}