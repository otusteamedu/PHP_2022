<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Infrastructure\Contollers;

use Eliasjump\HwStoragePatterns\App\BaseInfrastructure\BaseController;
use Eliasjump\HwStoragePatterns\App\Kernel\Response;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserDTO;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases\CreateUser;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases\DeleteUser;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases\GetUser;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases\GetUsersList;
use Eliasjump\HwStoragePatterns\Modules\Users\Application\UserUseCases\UpdateUser;
use Eliasjump\HwStoragePatterns\Modules\Users\Domain\User;

class UsersController extends BaseController
{
    public function index(): string
    {
        $users = GetUsersList::run();
        $users = array_map(function (User $user) {
            return $user->toArray();
        }, $users);

        return Response::json(200, $users);
    }

    public function create(): string
    {
        $name = $this->request->getPostParameter('name');
        $email = $this->request->getPostParameter('email');

        $dto = new UserDTO(name: $name, email: $email);
        $user = CreateUser::run($dto);

        return Response::json(200, $user->toArray());
    }

    public function read(): string
    {
        $userId = $this->request->getGetParameter('id');
        $user = GetUser::run($userId);

        return Response::json(200, $user->toArray());
    }

    public function update(): string
    {
        $userId = $this->request->getPostParameter('id');
        $name = $this->request->getPostParameter('name');
        $email = $this->request->getPostParameter('email');

        $dto = new UserDTO(id: (int)$userId);
        if (!is_null($name)) {
            $dto->name = $name;
        }
        if (!is_null($email)) {
            $dto->email = $email;
        }

        $user = UpdateUser::run($dto);

        return Response::json(200, $user->toArray());
    }

    public function delete(): string
    {
        $userId = $this->request->getPostParameter('id');

        DeleteUser::run($userId);

        return Response::json(200);
    }
}