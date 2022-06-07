<?php

declare(strict_types=1);

namespace App\Domain\Message;

use App\Application\DAO\ReportDao;

class ReportMessage
{
    private string $content;
    private string $idQueque;
    private ReportDao $reportDao;

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