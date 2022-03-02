<?php

declare(strict_types=1);

namespace Kirillov;

use DI\Container;
use Kirillov\Controller\StringController;
use Kirillov\Exception\InvalidPathException;
use Kirillov\Exception\InvalidMethodException;
use Kirillov\ValueObject\StatusCode;

class App
{
    private StringController $stringController;

    public function __construct()
    {
        $container = new Container();
        $this->stringController = $container->get(StringController::class);
    }

    public function run()
    {
        $this->validatePath();

        $string = $this->getString()['string'];
        $answer = $this->stringController->validate($string);

        echo json_encode([
            'message' => $answer,
            'code' => StatusCode::SUCCESS
        ], JSON_PRETTY_PRINT);
    }

    private function getString(): array
    {
        return json_decode(file_get_contents('php://input'), true, flags:JSON_THROW_ON_ERROR);
    }

    private function validatePath(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new InvalidMethodException();
        }

        $url = $this->parseUrl();

        if ($url[1] !== 'string' || $url[2] !== 'validate') {
            throw new InvalidPathException();
        }
    }

    private function parseUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return explode('/', $uri);
    }
}
