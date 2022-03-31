<?php

namespace Nka\Otus\Core\Http\Headers;

class ContentTypeHeader implements HeaderInterface
{
    const JSON = 'application/json';
    const HTML = 'text/html';
    const PLAIN = 'text/plain';

    protected string $field = 'Content-Type';
    protected string $value;

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->field . ': ' . $this->value;
    }
}