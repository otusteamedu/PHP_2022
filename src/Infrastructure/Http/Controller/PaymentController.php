<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\App\Payment\DTO\ChargeRequest;
use App\App\Payment\DTO\ChargeResponse;
use App\App\Service\ChargeRequestValidator;
use src\App\Gateway\Payment\PaymentSystemGatewayInterface;

class PaymentController
{
    /**
     * @path('/payment/charge')
     * @method(['POST'])
     */
    public function charge(
        ChargeRequest $request,
        ChargeRequestValidator $chargeRequestValidator,
        PaymentSystemGatewayInterface $paymentGateway
    ): ChargeResponse {
        // Валидируем входящий запрос
        if (!$chargeRequestValidator->isValid($request)) {
            // ...
        }
        //  - Если все ок, то передаем данные в сервис оплаты
        $paymentGateway->charge();
        //    - Если оплата прошла, сохраняем в БД
        //    - Если ошибка - передаем ее на фронт
    }
}