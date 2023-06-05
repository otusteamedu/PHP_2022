<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Domain;

readonly class Statement
{
    private string $date;
    private string $dateFrom;
    private string $dateTo;

    /**
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->date = $date;
        $tmpDate = explode("-", $date);

        $this->dateFrom = $tmpDate[0];
        $this->dateTo = $tmpDate[1];
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }
}