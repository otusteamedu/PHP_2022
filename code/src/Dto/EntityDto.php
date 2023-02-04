<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Dto;

class EntityDto
{
    /**
     * @var string|null
     */
    private ?string $name = null;
    /**
     * @var string|null
     */
    private ?string $multyName = null;

    /**
     * @param string|null $name
     * @param string|null $multyName
     */
    public function __construct(?string $name, ?string $multyName)
    {
        $this->name = $name;
        $this->multyName = $multyName;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getMultyName(): ?string
    {
        return $this->multyName;
    }

    /**
     * @param string|null $multyName
     */
    public function setMultyName(?string $multyName): void
    {
        $this->multyName = $multyName;
    }
}