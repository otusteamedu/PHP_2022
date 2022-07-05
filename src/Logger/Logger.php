<?php

namespace Logger;

use DateTime;
use Psr\Log\LoggerInterface;
use Throwable;
use Dto\MessageLog;
use Dto\ExceptionLog;

class Logger implements LoggerInterface
{
    /**
     * @param Throwable $message
     * @param array $context
     */
    public function error($message, array $context = array()): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = array()): void
    {
        $this->log('info', $message, $context);
    }

    /**
     * @param Throwable $message
     * @param array $context
     */
    public function critical($message, array $context = array()): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * @param int $level
     * @param Throwable|string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array()): void
    {
        $currentTimestamp = (new DateTime())->format('Y-m-d H:i:s');
        if ($message instanceof Throwable) {
            $log = new ExceptionLog();
            $log->lvl = $level;
            $log->message = $message->getMessage();
            $log->timeStamp = $currentTimestamp;
            $log->file = $message->getFile();
            $log->line = $message->getLine();
            $log->trace = $message->getTraceAsString();
        } else {
            $log = new MessageLog();
            $log->timeStamp = $currentTimestamp;
            $log->text = $message;
        }

        var_dump(json_encode(array($log)));
    }

    public function emergency($message, array $context = array()): void
    {}

    public function alert($message, array $context = array()): void
    {}

    public function warning($message, array $context = array()): void
    {}

    public function notice($message, array $context = array()): void
    {}

    public function debug($message, array $context = array()): void
    {}
}
