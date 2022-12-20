<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\v1;

use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\SaveAccountStatementDto;
use App\Application\Dto\Output\AccountStatementIdDto;
use App\Infrastructure\Consumer\CreateAccountStatement\Input\Message;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Uid\Uuid;

use App\Application\Dto\Output\AccountStatementDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

class AccountStatementController extends AbstractFOSRestController
{
    public function __construct(
        private AccountStatementManagerInterface $accountStatementManager,
        private ProducerInterface $producer
    ) {}

    /**
     * @Rest\Post("/api/v1/account-statements")
     * @ParamConverter("saveAccountStatementDto", converter="fos_rest.request_body")
     *
     * @OA\Post(
     *     operationId="addAccountStatement",
     *     tags={"Выписки"},
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\JsonContent(ref=@Model(type=SaveAccountStatementDto::class))
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref=@Model(type=AccountStatementIdDto::class))
     *     )
     * )
     *
     * @param  SaveAccountStatementDto $saveAccountStatementDto
     * @return Response
     */
    public function createAccountStatementAction(SaveAccountStatementDto $saveAccountStatementDto): Response
    {
        $id = Uuid::v4();
        if ($saveAccountStatementDto->isSync) {
            $this->accountStatementManager->create($id, $saveAccountStatementDto);
        } else {
            $message = Message::createFromDto($id, $saveAccountStatementDto);
            $this->producer->publish($message->toAMQPMessage());
        }

        $accountStatementIdDto = AccountStatementIdDto::create($id);
        return new Response(json_encode($accountStatementIdDto, JSON_UNESCAPED_UNICODE), Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/api/v1/account-statements/{id}")
     * @ParamConverter("saveAccountStatementDto", converter="fos_rest.request_body")
     *
     * @OA\Put(
     *     operationId="updateAccountStatement",
     *     tags={"Выписки"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid account statement",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\JsonContent(ref=@Model(type=SaveAccountStatementDto::class))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     *
     * @param Uuid $id
     * @param  SaveAccountStatementDto $saveAccountStatementDto
     * @return Response
     */
    public function updateAccountStatementAction(Uuid $id, SaveAccountStatementDto  $saveAccountStatementDto): Response
    {
        $this->accountStatementManager->update($id, $saveAccountStatementDto);

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/api/v1/account-statements/{id}")
     *
     * @OA\Delete(
     *     operationId="deleteAccountStatement",
     *     tags={"Выписки"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid account statement",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     *
     * @param Uuid $id
     * @return Response
     */
    public function deleteAccountStatementAction(Uuid $id): Response
    {
        $this->accountStatementManager->delete($id);

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/v1/account-statements/{id}")
     *
     * @OA\Get(
     *     operationId="getAccountStatement",
     *     tags={"Выписки"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Uuid account statement",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref=@Model(type=AccountStatementDto::class))
     *     )
     * )
     *
     * @param Uuid $id
     * @return Response
     */
    public function findAccountStatementAction(Uuid $id): Response
    {
        $response = $this->accountStatementManager->find($id);

        return new Response(json_encode($response, JSON_UNESCAPED_UNICODE), Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/api/v1/account-statements")
     *
     * @OA\Get(
     *     operationId="getAccountStatements",
     *     tags={"Выписки"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref=@Model(type=AccountStatementDto::class))
     *         )
     *     )
     * )
     *
     * @return Response
     */
    public function findAllAccountStatementAction(): Response
    {
        $accountStatementsDto = $this->accountStatementManager->findAll();

        return new Response(json_encode($accountStatementsDto, JSON_UNESCAPED_UNICODE), Response::HTTP_OK);
    }
}