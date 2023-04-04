<?php

namespace App\Controller\Api\v1;

use App\Entity\User;
use App\Manager\UserManager;
use App\DTO\UserDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;



#[Route(path: '/api/v1/user')]
class UserController extends AbstractController
{
  //

    public function __construct(private Environment $twig,
                                private UserManager $userManager,
                                private ValidatorInterface $validator,
                                private LoggerInterface $logger


    )
    {

    }

    #[Route(path: '', methods: ['GET'], name: 'api_v1_user_getusers')]
    public function getUsersAction(Request $request): Response
    {
        $perPage = $request->query->get('perPage');
        $page = $request->query->get('page');
        $users = $this->userManager->getUsers($page ?? $this->userManager::PAGINATION_DEFAULT_PAGE,
                                                    $perPage ?? $this->userManager::PAGINATION_DEFAULT_PER_PAGE);
        $code = empty($users) ?  Response::HTTP_NO_CONTENT :  Response::HTTP_OK;

        return new JsonResponse(['users' => array_map(static fn(User $user) => $user->toArray(), $users)], $code);
    }

    #[Route(path: '', methods: ['POST'])]
    public function saveUserAction(Request $request): Response
    {
        $userId = null;
        $errors_message = [];
        $userDTO = UserDTO::fromRequest($request);
        $errors = $this->validator->validate($userDTO);

        if (!count($errors)){
            $userId = $this->userManager->saveUserFromDTO(new User(), $userDTO);
        }
        else {
            foreach ($errors as $error) {
                 $errors_message[$error->getPropertyPath()][] = $error->getMessage();
            }
        }

        [$data, $code] = $userId === null ?
            [['success' => false, 'errors'=> $errors_message ],  Response::HTTP_BAD_REQUEST] :
            [['success' => true, 'userId' => $userId],  Response::HTTP_OK];

        return new JsonResponse($data, $code);

    }

    #[Route(path: '', methods: ['DELETE'])]
    public function deleteUserAction(Request $request): Response
    {
        $userId = $request->query->get('userId');
        $result = $this->userManager->deleteUser($userId);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteUserByIdAction(int $id): Response
    {
        $result = $this->userManager->deleteUser($id);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    #[Route(path: '', methods: ['PATCH'])]
    public function updateUserAction(Request $request): Response
    {
        $userId = $request->query->get('userId');
        $fullName = $request->query->get('fullName');
        $result = $this->userManager->updateUser($userId, $fullName);

        return new JsonResponse(['success' => $result], $result ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

}