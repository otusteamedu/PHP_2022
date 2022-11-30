<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;

class FormBuilderService implements FormBuilderInterface
{
    public function getForm(AbstractType $formType): FormInterface
    {
        $validator = Validation::createValidator();

        return Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension($validator))
            ->addType($formType)
            ->getFormFactory()
            ->createBuilder(get_class($formType))
            ->getForm();
    }
}