<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Models;


class ParenthesesChecker
{
    private string $error;

    public function check(string $text): bool
    {
        $counter = 0;
        foreach (\str_split($text) as $symbol) {
            if ($symbol === "(") {
                $counter++;
            } elseif ($symbol === ")") {
                $counter--;
            } else {
                $this->error = "Недопустимый символ в строке";
                return false;
            }

            if ($counter < 0) {
                break;
            }
        }

        if ($counter !== 0) {
            $this->error = "Неверная вложеность скобок";
            return false;
        }

        return true;
    }

    public function getError(): ?string
    {
        return $this->error ?? null;
    }
}