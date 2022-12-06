<?php

declare(strict_types=1);

namespace Sveta\Code;

use Sveta\Code\Http\Request;
use Sveta\Code\Http\RequestStatus;
use Sveta\Code\Http\Response;
use Sveta\Code\Services\CheckStrings;

final class App
{
    private CheckStrings $checkStrings;
    private RequestStatus $requestStatus;

    public function __construct(CheckStrings $checkStrings, RequestStatus $requestStatus)
    {
        $this->checkStrings = $checkStrings;
        $this->requestStatus = $requestStatus;
    }

    /**
     * @throws \Exception
     */
    public function run(): Response
    {
        if ($this->requestStatus->checkPost($_SERVER)) {
            $post = json_decode(file_get_contents("php://input"), true);
            if ($this->requestStatus->checkEmpty($post)) {
                $request = Request::create($post);
                $result = $this->checkStrings->check($request);

                if ($result) {
                    return new Response(200, 'Строка прошла проверку');
                } else {
                    return new Response(400, 'Строка не прошла проверку');
                }
            } else {
                return new Response(500, 'Строка не должна быть пустой');
            }
        } else {
            return new Response(500, 'Должен быть метод POST');
        }
    }
}