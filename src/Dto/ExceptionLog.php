<?php

namespace Dto;

class ExceptionLog
{
    public string $lvl;
    public string $timeStamp;
    public string $message;
    public string $file;
    public string $line;
    public string $trace;
}