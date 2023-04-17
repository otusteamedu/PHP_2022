<?php


namespace App\Controller\Report;


class Reporter
{
    /**
     * @psalm-return \Generator<array{int, int, int}>
     */
    public function report(): \Generator
    {
        for ($i = 1; $i <= 400_000; ++$i) {
            yield [
                $i,
                $i ** 2,
                $i ** 3,
            ];
        }
    }
}