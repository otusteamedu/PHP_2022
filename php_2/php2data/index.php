<?php
function get_hundred_values()
{
    for ($i = 1; $i <= 100; $i++) {
        yield $i;
    }
}

foreach (get_hundred_values() as $value) {
    echo '<pre>';
    print($value);
    echo '</pre>';
}
