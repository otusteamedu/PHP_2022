<?php

declare(strict_types=1);

namespace App\Domain\Message;

class ReportMessage
{
    private string $content;
    private string $idQueque;

    public function __construct(string $content, string $idQueque)
    {
        $this->content = $content;
        $this->idQueque = $idQueque;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getIdQueque(): string
    {
        return $this->idQueque;
    }
}