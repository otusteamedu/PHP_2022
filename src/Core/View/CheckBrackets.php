<?php

namespace Philip\Otus\Core\View;

use RuntimeException;

class CheckBrackets
{
    public function __invoke()
    {
        try {
            $string = $_POST['string'] ?? null;
            if (empty($string)) {
                throw new RuntimeException('Field string is required', 400);
            }
            if (!(is_string($string))) {
                throw new RuntimeException('only string', 400);
            }
            if ($this->checkSymbols($string, '()')) {
                dump('Everything is fine');
                return;
            }
            throw new RuntimeException('Everything is bad', 400);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            dump($e->getMessage());
        }
    }


    private function checkSymbols(string $str, string $symbol): bool
    {
        if (str_contains($str, $symbol)) {
            return $this->checkSymbols(str_replace($symbol, '', $str), $symbol);
        }
        return $str === "";
    }
}