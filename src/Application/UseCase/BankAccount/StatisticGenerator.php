<?php

declare(strict_types=1);

namespace App\Application\UseCase\BankAccount;

class StatisticGenerator
{
    public function generate(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): string
    {
        // ... сдесь долго формируем статистику по банковскому счету ...

        // добавил, чтобы было что вывести в терминале
        return <<<text
█████████████████████████████████████████████████████████
█─▄▄▄▄█─▄─▄─██▀▄─██─▄─▄─█▄─▄█─▄▄▄▄█─▄─▄─█▄─▄█─▄▄▄─█─▄▄▄▄█
█▄▄▄▄─███─████─▀─████─████─██▄▄▄▄─███─████─██─███▀█▄▄▄▄─█
▀▄▄▄▄▄▀▀▄▄▄▀▀▄▄▀▄▄▀▀▄▄▄▀▀▄▄▄▀▄▄▄▄▄▀▀▄▄▄▀▀▄▄▄▀▄▄▄▄▄▀▄▄▄▄▄▀
text . PHP_EOL;
    }
}