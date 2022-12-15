<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\v1;

use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\AccountStatementDto;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Uid\Uuid;

class AccountStatementController extends AbstractFOSRestController
{
    public function __construct(
        private AccountStatementManagerInterface $accountStatementManager,
        private ProducerInterface $producer
    ) {}

    /**
     * @Rest\Post("/v1/account-statements")
     * @ParamConverter("accountStatementDto", converter="fos_rest.request_body")
     * @param  AccountStatementDto $accountStatementDto
     * @return Response
     */
    public function createAsyncAccountStatementAction(AccountStatementDto $accountStatementDto): Response
    {
        $accountStatementDto->id = Uuid::v4();
        $this->producer->publish(json_encode($accountStatementDto, JSON_UNESCAPED_UNICODE));

        return new Response(json_encode(['id' => $accountStatementDto->id], JSON_UNESCAPED_UNICODE), Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/v1/account-statements/{id}")
     * @ParamConverter("accountStatementDto", converter="fos_rest.request_body")
     * @param Uuid $id
     * @param  AccountStatementDto $accountStatementDto
     * @return Response
     */
    public function updateAccountStatementAction(Uuid $id, AccountStatementDto  $accountStatementDto): Response
    {
        $accountStatementDto->id = $id;
        $this->accountStatementManager->update($accountStatementDto);

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/v1/account-statements/{id}")
     * @param Uuid $id
     * @return Response
     */
    public function deleteAccountStatementAction(Uuid $id): Response
    {
        $this->accountStatementManager->delete($id);

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/v1/account-statements/{id}")
     * @param Uuid $id
     * @return Response
     */
    public function findAccountStatementAction(Uuid $id): Response
    {
        $response = $this->accountStatementManager->find($id);

        return new Response(json_encode($response, JSON_UNESCAPED_UNICODE), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/v1/account-statements")
     * @return Response
     */
    public function findAllAccountStatementAction(): Response
    {
        $accountStatementsDto = $this->accountStatementManager->findAll();

        return new Response(json_encode($accountStatementsDto, JSON_UNESCAPED_UNICODE), Response::HTTP_OK);
    }
}