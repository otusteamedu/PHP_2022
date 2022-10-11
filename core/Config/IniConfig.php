<?php

namespace Otus\Core\Config;

class IniConfig extends AbstractConfig
{
    protected function setOptions(): void
    {
        $this->options = parse_ini_file($this->file, true);
    }
}