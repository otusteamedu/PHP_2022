<?php
declare(strict_types=1);

namespace Shilyaev\Strings;

class Response
{
    protected $status = 200;
    protected $message = 'OK';

    /**
     * @return string
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
        http_response_code($status);
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }


}