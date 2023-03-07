<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum OrderStatus
{
    case NEW;
    /** Принят в обработку */
    case ACCEPTED;
    case COOKING;
    case WAITING_FOR_WAITER;
    case DELIVERING_TO_CUSTOMER;
    case ACCEPTED_BY_CUSTOMER;
    /** на случай, если что-то пошло не так */
    case SOMETHING_WENT_WRONG;

    /** Завершение обработки заказа */
    case FINISHED;
    case DELIVERED_TO_CUSTOMER;
}