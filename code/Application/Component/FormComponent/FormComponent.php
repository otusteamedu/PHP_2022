<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent;

abstract class FormComponent
{
    protected FormComponent $parent;

    public function setParent(?FormComponent $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): FormComponent
    {
        return $this->parent;
    }

    public function add(FormComponent $component): void
    {
    }

    public function remove(FormComponent $component): void
    {
    }

    public function isComposite(): bool
    {
        return false;
    }

    abstract public function process(): void;
}