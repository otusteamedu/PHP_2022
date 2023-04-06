<?php

declare(strict_types=1);

namespace Svatel\Code;

use Svatel\Code\Controller\Controller;
use Svatel\Code\Http\Request\Request;

final class App
{
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                if (strpos($uri, 'add')) {
                    $post = json_decode(file_get_contents("php://input"), true);
                    $request = new Request($post);
                    $controller = new Controller($request);
                    $response = $controller->add();
                    print_r($response->getMessage());
                } elseif (strpos($uri, 'update')) {
                    preg_match('/\d+/', $uri, $matches);
                    if (isset($matches[0])) {
                        $post = json_decode(file_get_contents("php://input"), true);
                        $post['id'] = (int) $matches[0];
                        $request = new Request($post);
                        $controller = new Controller($request);
                        $res = $controller->update();
                        print_r($res->getMessage());
                    } else {
                        print_r('Введите id пользователя');
                    }
                } else {
                    print_r('Введите валидный роут');
                }
                break;
            case 'GET':
                preg_match('/\d+/', $uri, $matches);
                if (strpos($uri, 'find') && isset($matches[0])) {
                    $request = new Request([(int) $matches[0]]);
                    $controller = new Controller($request);
                    $response = $controller->findById();
                    print_r($response->getBody());
                } else {
                    print_r('Введите валидный роут');
                }
                break;
            case 'DELETE':
                preg_match('/\d+/', $uri, $matches);
                if (strpos($uri, 'delete') && isset($matches[0])) {
                    $request = new Request([(int) $matches[0]]);
                    $controller = new Controller($request);
                    $response = $controller->delete();
                    print_r($response->getMessage());
                } else {
                    print_r('Введите валидный роут');
                }
                break;
        }
    }
}
