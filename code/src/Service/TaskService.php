<?php

namespace App\Service;

use App\DTO\TaskDTO;
use App\Entity\Task;
use App\Entity\TaskSkills;
use App\Form\TaskSkillsType;
use App\Manager\TaskFormManager;
use App\Exception\DataValidationException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskService
{

    public function __construct(private TaskFormManager $taskManager,
                                private ValidatorInterface $validator,
                                private FormFactoryInterface $formFactory
    ){ }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('text', TextType::class)
            ->add('submit', SubmitType::class);
        ;
    }

    public function getSaveForm(): FormInterface
    {
        return $this->formFactory->createBuilder()
            ->add('title', TextType::class)
            ->add('text', TextType::class)
            ->add('submit', SubmitType::class);
            //->getForm();
    }
    public function  getUpdateForm(int $taskId): ?FormInterface
    {
        $task = $this->taskManager->findTask($taskId);
        if ($task === null) {
            return null;
        }

        return $this->formFactory->createBuilder(FormType::class, TaskDTO::fromEntity($task),  ['csrf_protection' => false])
            ->add('title', TextType::class)
            ->add('text', TextType::class)
            ->add('skills', CollectionType::class, [
                'entry_type' => TaskSkillsType::class,
                'entry_options' => ['label' => false],
            ])
            ->add('submit', SubmitType::class)
            ->setMethod('PATCH')
            ->getForm();
    }

    public function saveTaskFromForm(FormInterface $form): ?int
    {

        if ($form->isSubmitted() && $form->isValid()) {

            $taskDTO = new TaskDTO($form->getData());
            $errors =  $this->validateDTO($taskDTO);
            if(!empty($errors))
                throw new DataValidationException($errors);

            $taskId = $this->taskManager->saveTaskFromDTO(new Task(), new TaskDTO($form->getData()));
            if($taskId)
                return $taskId;

        }
        return null;
    }

    public function updateTaskFromForm(FormInterface $form, int $id):?int
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $errors =  $this->validateDTO($form->getData());
            if(!empty($errors))
                  throw new DataValidationException($errors->toString());

            $percent = 0;
            foreach ($form->getData()->skills as $skillData) {
                $percent += $skillData->percent;
            }
            if($percent > 100 ){
                //return ['errors' => [['message' => "Percent more then 100. "]]];
                throw new DataValidationException('Percent more then 100!');
            }

            $result = $this->taskManager->updateTaskFromDTO($id, $form->getData());
            return $result;
        }
        return null;

    }

    public function validateDTO($dto)
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0)
            return $errors;
        else
            return [];
    }

}


