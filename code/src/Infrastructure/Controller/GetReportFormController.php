<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Infrastructure\Service\FormBuilderInterface;
use Nikolai\Php\Infrastructure\Form\ReportFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class GetReportFormController implements ControllerInterface
{
    public function __construct(private FormBuilderInterface $formBuilder, private Environment $twig) {}

    public function __invoke(Request $request)
    {
        $form = $this->formBuilder->getForm(new ReportFormType());
        $formContent = $this->twig->render('report_form.twig', ['form' => $form->createView()]);

        return new Response($formContent);
    }
}