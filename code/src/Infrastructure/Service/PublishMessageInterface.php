<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

use Nikolai\Php\Application\Dto\Input\ReportFormDto;

interface PublishMessageInterface
{
    public function publishMessage(ReportFormDto $reportFormDto): bool;
}