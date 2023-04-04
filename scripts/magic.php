<?php

declare(strict_types=1);

interface MagicInterface
{
    public function setValue(string $value): MagicInterface;

    public function getValue(): string;

    /**
     * Разбивает хранимое значение с помощью разделителя
     */
    public function split(string $delimiter): MagicInterface;

    /**
     * Склеивает значение
     */
    public function glue(string $delimiter): MagicInterface;

    public function toUpperCase(): MagicInterface;

    public function reverse(): MagicInterface;
}

class Magic implements MagicInterface
{
    private $value;

    public function __construct()
    {
        $GLOBALS['magicValue'] = &$this->value;

        function setValue(string $value): string {
            global $magicValue;
            $magicValue = $value;
            return '';
        }

        function getValue(): string {
            global $magicValue;
            return $magicValue;
        }

        function split(string $delimiter): string {
            global $magicValue;
            $magicValue = \explode($delimiter, $magicValue);
            return '';
        }

        function glue(string $delimiter): string {
            global $magicValue;
            $magicValue = \implode($delimiter, $magicValue);
            return '';
        }

        function reverse(): string {
            global $magicValue;
            $magicValue = strrev($magicValue);
            return '';
        }

        function toUpperCase(): string {
            global $magicValue;
            $magicValue = \strtoupper($magicValue);
            return '';
        }
    }

    public function setValue(string $value): MagicInterface
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function split(string $delimiter): MagicInterface
    {
        $this->value = \explode($delimiter, $this->value);
        return $this;
    }

    public function glue(string $delimiter): MagicInterface
    {
        $this->value = \implode($delimiter, $this->value);
        return $this;
    }

    public function toUpperCase(): MagicInterface
    {
        $this->value = \strtoupper($this->value);
        return $this;
    }

    public function reverse(): MagicInterface
    {
        $this->value = \strrev($this->value);
        return $this;
    }

    public function __toString(): string
    {
        return '';
    }
}

$m = new Magic();

echo $m.setValue('2022-12-29-otus')
    .split('-')
    .glue('_')
    .reverse()
    .toUpperCase()
    .getValue()
;

