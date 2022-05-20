<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Application\Contract\CreateRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


class CreateRequestDto implements CreateRequestInterface
{
    private mixed $id;

    private mixed $value;

    private ?Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();

        $this->setId($this->request->get('id'));
        $this->setValue($this->request->get('value'));
    }

    /**
     * @param mixed $id
     * @return CreateRequestDto
     */
    public function setId(string $id = null): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $string
     * @return CreateRequestDto
     */
    public function setValue(string $string = null): static
    {
        $this->value = $string;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

}