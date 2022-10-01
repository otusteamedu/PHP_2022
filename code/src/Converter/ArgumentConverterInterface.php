<?php

namespace Nikolai\Php\Converter;

interface ArgumentConverterInterface
{
    const SEPARATOR = '=';
    const ITEM_SEPARATOR = '.AND.';
    const VALUE_SEPARATOR = ':';

    public function convert(): array;
}