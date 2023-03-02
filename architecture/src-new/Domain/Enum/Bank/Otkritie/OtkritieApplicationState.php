<?php

namespace App\Domain\Enum\Bank\Otkritie;

use App\Domain\Enum\Bank\Common\BankApplicationStateInterface;

/**
 * Статус сделки на стороне банка Открытие.
 */
enum OtkritieApplicationState: string implements new\Domain\Enum\Bank\Common\Enum\BankApplicationStateInterface
{
    case SENT = 'Заявка отправлена в банк';
    case TECHNICAL_ERROR = 'Ошибка при отправке';
    case REJECTED = 'Отказ банка';
    case APPROVED = 'Одобрено';
    case RETURNED_FOR_REVISION = 'На доработке';
    case CLIENT_REFUSED = 'Отказ клиента';

    case PREAPPROVAL = 'Предварительное одобрение';
    case PLEDGE_APPROVAL = 'Одобрение залога';
    case LOAN_HAS_BEEN_ISSUED = 'Кредит выдан клиенту';
    case SIGNING_OF_DOCUMENTS = 'Подписание документов';

    public function getStateName(): string
    {
        return $this->name;
    }

    public function getStateValue(): string
    {
        return $this->value;
    }
}
