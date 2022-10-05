<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent;

use SplObjectStorage;

class ComplexFormElement extends FormComponent
{
    protected SplObjectStorage $children;

    public function __construct()
    {
        $this->children = new SplObjectStorage();
    }

    public function add(FormComponent $component): void
    {
        $this->children->attach($component);
        $component->setParent($this);
    }

    public function remove(FormComponent $component): void
    {
        $this->children->detach($component);
        $component->setParent(null);
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function process(): void
    {
        foreach ($this->children as $child) {
            $child->process();
        }
    }
}