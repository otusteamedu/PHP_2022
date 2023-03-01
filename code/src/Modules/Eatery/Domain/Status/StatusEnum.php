<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Status;

Enum StatusEnum: string
{
    case PENDING = "Pending";
    case PROCESSING = "Processing";
    case COMPLETED = "Completed";
    case CANCELLED = "Cancelled";
    case FAILED = "Failed";
    case REFUNDED = "Refunded";
}