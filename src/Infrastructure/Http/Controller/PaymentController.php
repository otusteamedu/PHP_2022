<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\App\Payment\DTO\ChargeRequest;
use App\App\Payment\DTO\ChargeResponse;
use App\App\Service\ChargeRequestValidator;

class PaymentController
{
    public function __construct(
        private readonly ChargeRequestValidator $chargeRequestValidator
    ) {
    }

    public function charge(ChargeRequest $request): ChargeResponse
    {
        // Валидируем входящий запрос
        if (!$this->chargeRequestValidator->isValid($request)) {
            // ...
        }
        //  - Если все ок, то передаем данные в сервис оплаты
        //    - Если оплата прошла, сохраняем в БД
        //    - Если ошибка - передаем ее на фронт
    }
}