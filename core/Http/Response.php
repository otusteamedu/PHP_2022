<?php
declare(strict_types=1);

namespace Otus\Task07\Core\Http;
use \Stringable;

class Response implements Stringable
{

    public function __construct(private string|Stringable $result, private int $status = 200){}

    public function __toString(): string
    {
        http_response_code($this->status);
        return (string)$this->result;
    }
}