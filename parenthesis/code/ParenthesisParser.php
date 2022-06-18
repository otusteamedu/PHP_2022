<?php
declare(strict_types=1);

// Expression       = SimpleExpression+
// SimpleExpression = Primitive | ( Expression )
// Primitive        = ()

class ParenthesisParser
{
    private string $expression;

    private int $pointer;

    public function checkExpression(string $expression): void
    {
        $this->expression = $expression;
        $this->pointer = 0;
        $this->expression();

        if (!$this->isEOF()) {
            $this->error("Unexpected symbol {$this->checkSymbol()}");
        }
    }

    private function expression(): void
    {
        $this->simpleExpression();

        while (!$this->isEOF() && $this->checkSymbol() == '(') {
            $this->simpleExpression();
        };

    }

    private function simpleExpression(): void
    {
        if ($this->isPrimitive()) {
            return;
        }

        if (!($c = $this->getSymbol())) {
            $this->error("Unexpected end of string");
        }

        if ($c != '(') {
            $this->error("'(' expected", 1);
        }

        $this->expression();

        if (!($c = $this->getSymbol())) {
            $this->error("Unexpected end of string");
        }

        if ($c != ')') {
            $this->error("')' expected", 1);
        }
    }

    // true -- если завершенный примитив
    // false -- если это НЕ примитив
    private function isPrimitive(): bool
    {
        $position = $this->pointer;

        try {
            $this->primitive();
        } catch (Exception $e) {
            $this->rollback($position);
            return false;
        }

        return true;
    }

    private function primitive(): void
    {
        if (!($c = $this->getSymbol())) {
            $this->error("Unexpected end of string");
        }

        if ($c != '(') {
            $this->error("'(' expected", 1);
        }

        if (!($c = $this->getSymbol())) {
            $this->error("Unexpected end of string");
        }

        if ($c != ')') {
            $this->error("')' expected", 1);
        }
    }

    private function getSymbol(): string | false
    {
        if ($this->isEOF()) {
            return false;
        }

        return $this->expression[$this->pointer++];
    }

    private function checkSymbol(): string | false
    {
        if ($this->isEOF()) {
            return false;
        }

        return $this->expression[$this->pointer];
    }

    private function isEOF(): bool
    {
        return $this->pointer == strlen($this->expression);
    }

    private function error(string $msg, int $previous = 0): void
    {
        $position = $this->pointer;

        if (!$previous) {
            $position++;
        }

        $trace = $this->trace($position);

        throw new Exception(
            "Error at position {$position}. {$msg}\n{$trace}"
        );
    }

    private function rollback(int $position): void
    {
        $this->pointer = $position;
    }

    private function trace(int $position): string
    {
        $result = $this->expression . "\n";

        for ($i = 0; $i < $position-1; $i++) {
            $result .= '.';
        }

        $result .= '|';

        for ($i = $position; $i < strlen($this->expression); $i++) {
            $result .= '.';
        }

        return $result;
    }
}