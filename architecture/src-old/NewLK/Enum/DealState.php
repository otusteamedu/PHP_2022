<?php

namespace App\NewLK\Enum;

/**
 * Статусы сделки из NewLK
 */
enum DealState: string
{
    case SENT = 'sent';

    case TECHNICAL_ERROR = 'technical_error';
    case REJECTED = 'declined';
    case APPROVED = 'approved';
    case RETURNED_FOR_REVISION = 'request-info-underwriting';
    case CLIENT_REFUSED = 'customer-decline-after';
    case MORTGAGE_SIGNING = 'contract-issue';
    case FINANCED = 'financed';

    public function getTitle(): string
    {
        return match ($this) {
            self::SENT => 'Отправлено в банк',
            self::REJECTED => 'Отказ банка',
            self::APPROVED => 'Одобрено',
            self::TECHNICAL_ERROR => 'Техническая ошибка',
            self::RETURNED_FOR_REVISION => 'На доработке',
            self::CLIENT_REFUSED => 'Отказ клиента',
            self::MORTGAGE_SIGNING => 'contract-issue',
            self::FINANCED => 'financed',
            default => 'Неизвестный статус',
        };
    }
}
