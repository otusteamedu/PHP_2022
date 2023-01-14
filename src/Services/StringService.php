<?php
declare(strict_types=1);

namespace Larisadebelova\Php2022\Services;

use Larisadebelova\ComposerPackage\StringProcessor;

class StringService
{
    /**
     * Получить строку через пакет
     * @param string $str
     * @return int
     */
    public function getLength(string $str): int
    {
        $processor = new StringProcessor();

        return $processor->getLength($str);
    }
}