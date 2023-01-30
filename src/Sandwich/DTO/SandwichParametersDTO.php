<?php

declare(strict_types=1);

namespace Src\Sandwich\DTO;

final class SandwichParametersDTO
{
    /**
     * @var string
     */
    public string $sandwich_prototype;

    /**
     * @var array
     */
    public array $sandwich_partials;

    /**
     * @param string $sandwich_prototype
     * @param array $sandwich_partials
     */
    public function __construct(string $sandwich_prototype, array $sandwich_partials)
    {
        $this->sandwich_prototype = $sandwich_prototype;
        $this->sandwich_partials = $sandwich_partials;
    }
}
