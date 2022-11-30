<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Form;

use Nikolai\Php\Application\Dto\Input\ReportFormDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ReportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['constraints' => [new Length(['min' => 3])]])
            ->add('dateBeginning', DateType::class)
            ->add('dateEnding', DateType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReportFormDTO::class,
        ]);
    }
}