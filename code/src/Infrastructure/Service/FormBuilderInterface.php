<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;

interface FormBuilderInterface
{
    public function getForm(AbstractType $formType): FormInterface;
}