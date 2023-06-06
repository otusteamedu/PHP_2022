<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Domain;

use DateTimeImmutable;
use Exception;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Exception\InvalidDate;

readonly class Statement
{
    private const DATE_FORMAT = "d.m.Y";

    private DateTimeImmutable $dateFrom;
    private DateTimeImmutable $dateTo;

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @throws InvalidDate
     */
    public function __construct(string $dateFrom, string $dateTo)
    {
        try {
            $this->dateFrom = new DateTimeImmutable($dateFrom);
            $this->dateTo = new DateTimeImmutable($dateTo);
        } catch (Exception $e) {
            throw new InvalidDate($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->dateFrom->format(self::DATE_FORMAT) . " - " . $this->dateTo->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom->format(self::DATE_FORMAT);
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo->format(self::DATE_FORMAT);
    }
}