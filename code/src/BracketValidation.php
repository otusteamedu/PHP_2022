<?php

declare(strict_types=1);

namespace Ilia\Otus;

use Ilia\Otus\Http\Request;
use Ilia\Otus\Http\Response;

class BracketValidation
{
    public function __construct()
    {
        // устанавливаем свойства класса
        $this->request      = new Request();
        $this->response  = new Response();
        if (!$this->request->isPost()) {
            $this->response->setContent('Метод должен быть POST');
        }
    }

    public function run($string)
    {


        if (!$string) {   
            $this->response->setContent('Строка пустая');
            $this->response->setStatusCode(400);
            return $this->response->send();
        }

        $counter = 0;

        $openBracket = ['('];
        $closedBracket = [')'];

        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $char = $string[$i];

            if (in_array($char, $openBracket)) {
                $counter++;
            } elseif (in_array($char, $closedBracket)) {
                $counter--;
            }
        }

        if ($counter != 0) {
            $this->response->setContent('Строка не валидна');
            $this->response->setStatusCode(400);
            return $this->response->send();
      
        }
        
        $this->response->setContent('Строка валидна');
        return $this->response->send();
    }
}
