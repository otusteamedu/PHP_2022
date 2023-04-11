<?php

namespace App\Form;

use App\DTO\TaskSkillsDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskSkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('percent', IntegerType::class, ['label' => 'Доля навыка в задании'])
            ->add('skillId', HiddenType::class)
            ->add('skillTitle', TextType::class, ['label' => 'Навык']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskSkillsDTO::class,
            'cascade_validation' => true,

        ]);
    }
}