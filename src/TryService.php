<?php
function tryService(string $name, callable $inspect): void
{
    try {
        $inspect();
        echo "{$name} успешно работает <br><br>";
    } catch (\Exception $e) {
        echo "<br>{$name} не работает: <br> {$e->getMessage()}";
        $trace = str_replace('#', "<br>#", $e->getTraceAsString());
        echo "<br>Trace:{$trace}<br><br>";
    }
}