<?php

namespace Koptev\Controllers;

use Koptev\Components\StringBracket;
use Koptev\Exceptions\EmptyStringException;
use Koptev\Exceptions\WrongBracketsException;
use Koptev\Support\Request;
use Koptev\Support\Response;
use Throwable;

class StringController
{
    /**
     * Run application.
     *
     * @return void
     */
    public function verify(Request $request): Response
    {
        $response = new Response();

        try {
            $string = $request->post('string');

            $stringBracket = new StringBracket($string);

            $stringBracket->check();

            $response->ok('Строка корректна.');

        } catch (EmptyStringException $e) {

            $response->badRequest('Ошибка: пустая строка.');

        } catch (WrongBracketsException $e) {

            $response->badRequest('Ошибка: скобки некорректны.');

        } catch (Throwable $e) {

            $response->badRequest('Ошибка: ' . $e->getMessage());

        }

        return $response;
    }
}
