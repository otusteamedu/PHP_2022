<?php

declare(strict_types=1);

namespace Nikolai\Php;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Nikolai\Php\Service\BracketsVerifier;
use Nikolai\Php\Service\VerifierInterface;
use Symfony\Component\HttpFoundation\Response;

class Application implements ApplicationInterface
{
    const REQUIRED_POST_PARAMETER = 'string';
    private VerifierInterface $verifier;

    public function __construct()
    {
        $this->verifier = new BracketsVerifier();
    }

    public function run(): void
    {
        $res = session_start();
        echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';
        echo '<pre>';
        var_dump($res);
        echo '</pre>';

        echo '<br>session_id: ';
        var_dump(session_id());
        echo '<br>';

//        $_SESSION['a'] = 111;

        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';

        phpinfo();

        try {
            $request = Request::createFromGlobals();
            if (!$request->request->has(self::REQUIRED_POST_PARAMETER)) {
                throw new BadRequestException('Нет обязательного POST-параметра с именем string!');
            }

            $string = $request->request->get(self::REQUIRED_POST_PARAMETER);
            $this->verifier->verify($string);

            $response = new Response('Запрос корректен!', Response::HTTP_OK);
            $response->send();
        } catch (\Exception $e) {
            $response = new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
            $response->send();
        }
    }
}