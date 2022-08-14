<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ashvedov\ArrayFlatten\ArrFlatten;

echo "Hello world" . PHP_EOL;

$test_arrays = [
    [[1, 2, [3, 5], [[4, 3], 4], 10], [1, 2, 3, 5, 4, 3, 4, 10]],
    ['a', 'b'],
    ['a', 'b', [1, 2, [3, 'test', [4, 5]]]]
];

foreach ($test_arrays as $test_array) {
    $test = new ArrFlatten(array: $test_array);

    echo "<pre>";
    var_dump(value: $test->flattenArray());
    echo "</pre>" . PHP_EOL;
}
