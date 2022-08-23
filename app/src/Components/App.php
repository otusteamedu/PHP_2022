<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Components;

use Nemizar\Php2022\Validators\RoundBracketValidator;

class App
{
    public function run(): void
    {
        Router::get('/', static function () {
            require '../view/view.php';
        });

        Router::post('/', static function (array $request) {
            $string = $request['string'] ?? '';
            $stringIsValid = (new RoundBracketValidator())->validate($string);
            if ($stringIsValid) {
                echo 'Введенная строка корректна';
            } else {
                \header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                echo 'Введенная строка не корректна';
            }
            require '../view/view.php';
        });

        Router::run();
    }
}
