<?php

/**
 * Translit class usage example
 */

require __DIR__ . '/../vendor/autoload.php';

use nujensait\Translit\Translit;

$transl = new Translit();

// OK: Known locale
$str = "Текст на русском";
$str = $transl->transliterateText($str, 'Russian-Latin/BGN');
echo $str;
echo "\n\n";

// Error: Unkonwn locale
$str = "Текст на русском";
try {
    $str = $transl->transliterateText($str, 'asdfasfas');
    echo $str;
} catch(Exception $e) {
    echo $e->getMessage();
}
echo "\n\n";
