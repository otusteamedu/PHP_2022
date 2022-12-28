<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Contract\ApiClientInterface;
use App\Infrastructure\Form\AccountStatementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AccountStatementController extends AbstractController
{
    private const METHOD = "POST";
    private const API_URL = "http://proxy-nginx/api/v1/account-statements";

    public function __construct(
        private FormFactoryInterface $formFactory,
        private Environment $twig,
        private ApiClientInterface $apiClient
    ) {}

    /**
     * @Route("/form", methods={"GET"})
     */
    public function getAccountStatementFormAction(): Response
    {
        $form = $this->formFactory->createBuilder(AccountStatementFormType::class)->getForm();
        $content = $this->twig->render('form.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }

    /**
     * @Route("/form", methods={"POST"})
     */
    public function postAccountStatementFormAction(Request $request): Response
    {
        $form = $this->formFactory->createBuilder(AccountStatementFormType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountStatementFormDto = $form->getData();

            $options['json'] = [
                'name' => $accountStatementFormDto->name,
                'dateBeginning' => $accountStatementFormDto->dateBeginning->format('d.m.Y'),
                'dateEnding' => $accountStatementFormDto->dateEnding->format('d.m.Y'),
                'isSync' => false
            ];

            $response = $this->apiClient->request(self::METHOD, self::API_URL, $options);
            $responseContent = $response->getBody()->getContents();
            $result = json_decode($responseContent, true);

            $successFormContent = $this->twig->render('success_form.twig', [
                'form' => $form->createView(),
                'message' => $responseContent,
                'id' => $result['id']
            ]);
            return new Response($successFormContent);
        }

        $formContent = $this->twig->render('form.twig', ['form' => $form->createView()]);
        return new Response($formContent);
    }
}
