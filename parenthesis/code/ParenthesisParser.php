<?php
declare(strict_types=1);

// Expression       = SimpleExpression+
// SimpleExpression = Primitive | ( Expression )
// Primitive        = ()

class ParenthesisParser
{
    private $expression;
    private $pointer;

    public function checkExpression(string $expression)
    {
        $this->expression = $expression;
        $this->pointer = 0;
        $this->expression();

        if (!$this->isEOF()) {
            $this->error("Unexpected symbol {$this->checkSymbol()}");
        }
    }

    private function expression()
    {
        $this->simpleExpression();

        while (!$this->isEOF() && $this->checkSymbol() == '(') {
            $this->simpleExpression();
        };

    }

    private function simpleExpression()
    {
        if ($this->isPrimitive()) {
            return;
        }

        if (!($c = $this->getSymbol())) {
            $this->error("simpleExpression: Unexpected end of string");
        }

        if ($c != '(') {
            $this->error("simpleExpression: '(' expected");
        }

        $this->expression();

        if (!($c = $this->getSymbol())) {
            $this->error("simpleExpression: Unexpected end of string");
        }

        if ($c != ')') {
            $this->error("'simpleExpression: )' expected");
        }

    }

    // true -- если завершенный примитив
    // false -- если это сразу НЕ примитив
    private function isPrimitive()
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

    private function primitive()
    {
        if (!($c = $this->getSymbol())) {
            $this->error("primitive: Unexpected end of string");
        }

        if ($c != '(') {
            $this->error("primitive: Symbol '(' expected");
        }

        if (!($c = $this->getSymbol())) {
            $this->error("primitive: Unexpected end of string");
        }

        if ($c != ')') {
            $this->error("primitive: Symbol ')' expected");
        }
    }

    private function getSymbol()
    {
        if ($this->isEOF()) {
            return false;
        }

        return $this->expression[$this->pointer++];
    }

    private function checkSymbol()
    {
        if ($this->isEOF()) {
            return false;
        }

        return $this->expression[$this->pointer];
    }

    private function isEOF()
    {
        return $this->pointer == strlen($this->expression);
    }

    private function error($msg)
    {
        $trace = $this->trace();
        $position = $this->pointer + 1;

        throw new Exception(
            "Error at position {$position}. {$msg}\n{$trace}"
        );
    }

    private function rollback($position)
    {
        $this->pointer = $position;
    }

    private function trace()
    {
        $result = $this->expression . "\n";

        for ($i = 0; $i < $this->pointer; $i++) {
            $result .= '.';
        }

        $result .= '|';

        for ($i = $this->pointer+1; $i < strlen($this->expression); $i++) {
            $result .= '.';
        }

        return $result;
    }
}