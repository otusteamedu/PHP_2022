<?php

namespace Logger;

use DateTime;
use Dto\ExceptionLog;
use Dto\MessageLog;
use Psr\Log\LoggerInterface;
use Throwable;

class Logger implements LoggerInterface
{
    public function error($message, array $context = array()): void
    {
        $this->log('error', $message, $context);
    }

    public function info($message, array $context = array()): void
    {
        $this->log('info', $message, $context);
    }

    public function critical($message, array $context = array()): void
    {
        $this->log('critical', $message, $context);
    }

    public function log($level, $message, array $context = array()): void
    {
        if ($message instanceof Throwable) {
            $log = new ExceptionLog();
            $log->lvl = $level;
            $log->message = $message->getMessage();
            $log->file = $message->getFile();
            $log->line = $message->getLine();
            $log->trace = $message->getTraceAsString();
        } else {
            $log = new MessageLog();
            $log->message = $message;
        }
        $log->timeStamp = (new DateTime())->format('Y-m-d H:i:s');

        var_dump(json_encode(array($log), JSON_THROW_ON_ERROR));
    }

    public function emergency($message, array $context = array()): void
    {
    }

    public function alert($message, array $context = array()): void
    {
    }

    public function warning($message, array $context = array()): void
    {
    }

    public function notice($message, array $context = array()): void
    {
    }

    public function debug($message, array $context = array()): void
    {
    }
}