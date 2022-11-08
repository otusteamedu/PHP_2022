<?php

declare(strict_types = 1);

namespace VeraAdzhieva\Hw3\Service;

use Carbon\Carbon;

class Age
{
    /*
     * Возраст.
     *
     * @param int $year Год.
     * @param int $month Месяц.
     * @param int $day День.
     *
     * @return int Возраст.
     */
    public function getAge(int $year, int $month, int $day): int
    {
        return Carbon::createFromDate($year, $month, $day)->age;
    }

    /*
     * Получение даты.
     *
     * @return Дата.
     */
    public function getDate()
    {
        return Carbon::now()->toDateTimeString();
    }

}