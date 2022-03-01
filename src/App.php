<?php

declare(strict_types=1);

namespace Kirillov;

use DI\Container;
use Exception;
use Kirillov\Controller\StringController;
use Kirillov\ValueObject\StatusCode;
use Symfony\Component\Dotenv\Exception\PathException;

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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(StatusCode::METHOD_NOT_ALLOWED);
            throw new Exception('Only POST method allowed.');
        }

        $url = $this->parseUrl();

        if ($url[1] !== 'string' || $url[2] !== 'validate') {
            http_response_code(StatusCode::BAD_REQUEST);
            throw new Exception('Unknown path.');
        }

        $string = json_decode(file_get_contents('php://input'), true, flags:JSON_THROW_ON_ERROR);

        echo $this->stringController->validate($string['string']);
    }

    public function parseUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return explode('/', $uri);
    }
}
