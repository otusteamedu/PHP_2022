<?php

namespace App\Service;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReportService
{

    public function __construct( private ValidatorInterface $validator,
                                private FormFactoryInterface $formFactory
    ){ }

    public function getParamForm(): FormInterface
    {
        return $this->formFactory->createBuilder()
            ->add('column1', ChoiceType::class, [
                'choices'  => [

                    'не указано' => 'null',
                    'task' => 'task',

                ],
            ])
            ->add('column2', ChoiceType::class, [
                'choices'  => [
                    'не указано' => 'null',
                    'taskSkills' => 'taskSkills',
                ],
            ])

            ->add('submit', SubmitType::class)
            ->getForm();
    }



}


