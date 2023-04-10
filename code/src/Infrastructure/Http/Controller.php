<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure;

use Svatel\Code\Application\Dto\EmailDto;
use Svatel\Code\Application\Services\EmailService;
use Svatel\Code\Domain\Email;

final class Controller
{
    private Request $request;
    private EmailService $service;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function checkEmail(): Response
    {
        try {
            $res = $this->service->checkEmail($this->request->getData()['email']);

            return !is_null($res)
                ? new Response(201, 'Email существует')
                : new Response(201, 'Email не существует');
        } catch (\Exception $e) {
            return new Response(500, 'Ошибка при валидации');
        }

    }
}
