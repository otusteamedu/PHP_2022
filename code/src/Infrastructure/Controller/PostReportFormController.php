<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Infrastructure\Service\FormBuilderInterface;
use Nikolai\Php\Infrastructure\Form\ReportFormType;
use Nikolai\Php\Infrastructure\Service\PublishMessageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class PostReportFormController implements ControllerInterface
{
    private const SUCCESS = 'Запрос выписки успешно отправлен';
    private const FAIL = 'Ошибка при отправке запроса выписки';

    public function __construct(
        private FormBuilderInterface $formBuilder,
        private Environment $twig,
        private PublishMessageInterface $publishMessageService
    ) {}

    public function __invoke(Request $request)
    {
        $form = $this->formBuilder->getForm(new ReportFormType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reportFormDto = $form->getData();
            $resultMessage = $this->publishMessageService->publishMessage($reportFormDto) ? self::SUCCESS : self::FAIL;

            $successFormContent = $this->twig->render('success_report_form.twig', ['message' => $resultMessage]);
            return new Response($successFormContent);
        }

        $formContent = $this->twig->render('report_form.twig', ['form' => $form->createView()]);
        return new Response($formContent);
    }
}