<?php

declare(strict_types=1);

namespace App\Domain\Message;

use App\Infrastructure\Requests\ReportDataRequest;

class ReportMessage
{
    private string $type;
    private string $name;
    private string $url;
    private string $idQueque;

    public function __construct(string $type, ReportDataRequest $content, string $id)
    {
        $this->type = $type;
        $this->name = $content->getName() ?? "";
        $this->url = $content->getUrl() ?? "";
        $this->idQueque = $id;
    }

    /**
     * @return string
     */
    public function getIdQueque(): string
    {
        return $this->idQueque;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
