<?php

declare(strict_types=1);

namespace Ekaterina\Hw5\Helpers;

class ViewHelper
{
    /**
     * Подготовка данных для вывода результата в командной строке
     * 
     * @param array $arResult
     * @return array
     */
    public static function prepareOutputResultToCommand(array $arResult): array
    {
        $arOutput  = [];

        foreach ($arResult as $key => $value) {
            if ($value['valid']) {
                $content = "<info>$key - success</info>";
            } else {
                $content = "<error>$key - error</error>";
                if (!empty($value['description'])) {
                    $content .= " ({$value['description']})";
                }
            }
            $arOutput[] = $content . PHP_EOL;
        }

        return $arOutput;
    }
}