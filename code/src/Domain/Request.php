<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Domain;

readonly class Request
{
    private string $id;
    private Status $status;

    /**
     * @param string $id
     * @param Status $status
     */
    public function __construct(string $id, Status $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}