<?php

include "./Classes/Request.php";
include "./Classes/Response.php";
include "./Classes/StringBracket.php";
include "./Classes/Exceptions/EmptyStringException.php";
include "./Classes/Exceptions/WrongBracketsException.php";

use Classes\Exceptions\EmptyStringException;
use Classes\Exceptions\WrongBracketsException;
use Classes\Request;
use Classes\Response;
use Classes\StringBracket;

$request = new Request();

$string = $request->post('string');

$stringBracket = new StringBracket($string);

$response = new Response();

try {

    $stringBracket->check();

    $response->ok('Строка корректна.');

} catch (EmptyStringException $e) {

    $response->badRequest('Ошибка: пустая строка.');

} catch (WrongBracketsException $e) {

    $response->badRequest('Ошибка: скобки некорректны.');

} catch (Throwable $e) {

    $response->badRequest('Ошибка: ' . $e->getMessage());

}
