<?php

declare(strict_types=1);

namespace App\Domain\Message;

class ReportMessage
{
    private string $type;
    private string $name;
    private string $url;
    private string $idQueque;

    public function __construct(string $type, array $content, string $id)
    {
        $this->type = $type;
        $this->name = $content['name'] ?? "";
        $this->url = $content['url'] ?? "";
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
