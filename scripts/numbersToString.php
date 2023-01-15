<?php

function numbersConcat(int ...$numbers): string {
    $str = '';
    $length = \count($numbers);
    for ($i = 0; $i < $length; $i++) {
        if ($i === 0) {
            $str .= $numbers[$i];
            continue;
        }

        if ($numbers[$i] === $numbers[$i - 1] + 1) {
            if (!str_ends_with($str, '-')) {
                $str .= '-';
            }
            if ($i === $length - 1) {
                $str .= $numbers[$i];
            }
            continue;
        }

        if (!str_ends_with($str, $numbers[$i - 1])) {
            $str .= $numbers[$i - 1];
        }
        $str .= ',' . $numbers[$i];
    }

    return $str;
}

$cases = [
    // вариант из дз
    // корректный вывод 1-3,5,7-10
    [1, 2, 3, 5, 7, 8, 9, 10],
    // добавляем отрицательные значения и 0
    // корректный вывод -10--8,-4,0,2-3,5,7-10
    [-10, -9, -8, -4, 0, 2, 3, 5, 7, 8, 9, 10],
    // без интервалов
    // корректный вывод -9,-7,-5,-2,0,2,5,7,10
    [-9, -7, -5, -2, 0, 2, 5, 7, 10],
    // один сплошной интервал
    // корректный вывод -10-7
    [-10, -9, -8, -7, -6, -5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5, 6, 7]
];

foreach ($cases as $case) {
    echo numbersConcat(...$case) . PHP_EOL;
}