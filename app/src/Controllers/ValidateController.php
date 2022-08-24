<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Controllers;

use Nemizar\Php2022\Components\Render;
use Nemizar\Php2022\Validators\RoundBracketValidator;

class ValidateController
{
    /**
     * @var \Nemizar\Php2022\Components\Render
     */
    private Render $render;

    public function __construct()
    {
        $this->render = new Render();
    }

    public function validate(array $request): void
    {
        $string = $request['string'] ?? '';
        $stringIsValid = (new RoundBracketValidator())->validate($string);
        if ($stringIsValid) {
            $result = 'Введенная строка корректна';
        } else {
            \header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
            $result = 'Введенная строка не корректна';
        }
        echo $this->render->render('../view/view.php', ['result' => $result]);
    }
}
