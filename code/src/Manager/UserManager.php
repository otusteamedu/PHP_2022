<?php

namespace App\Manager;

use App\Entity\User;
use App\Exception\DataSourceException;
use App\Manager\StudentManager;
use App\Repository\UserRepository;
use App\DTO\UserDTO;


use Doctrine\ORM\EntityManagerInterface;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\MappingException;
use PDOException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class UserManager implements CommonManager

{
    private EntityManagerInterface $entityManager;
   // private FormFactoryInterface $formFactory;
    private UserPasswordHasherInterface $userPasswordHasher;
    private StudentManager $studentManager;
    private TeacherManager $teacherManager;


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher,
                                StudentManager $studentManager, TeacherManager $teacherManager
    )
    {
        $this->entityManager = $entityManager;
      //  $this->formFactory = $formFactory;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->studentManager = $studentManager;
        $this->teacherManager = $teacherManager;
    }

    public function saveUser(string $fullName): ?int
    {
        $user = new User();
        $user->setName($fullName);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getId();
    }

    public function updateUser(int $userId, string $fullName): bool
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }
        $user->setName($fullName);
        $this->entityManager->flush();

        return true;
    }

    public function deleteUser(int $userId): bool
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }

    public function saveUserFromDTO(User $user, UserDTO $userDTO): ?int
    {
        try {

            $user->setLogin( $userDTO->login );
            $user->setFullName( $userDTO->fullName );
            $user->setAge( $userDTO->age );
            $user->setPassword( $this->userPasswordHasher->hashPassword( $user, $userDTO->password ) );
            $user->setEmail( $userDTO->email );
            $user->setIsActive( $userDTO->isActive );
            $user->setRoles( $userDTO->roles );
            $this->entityManager->persist( $user );
            $this->entityManager->flush();


            if (in_array( User::USER_ROLE_STUDENT, $userDTO->roles )) {
                $this->studentManager->saveStudent( $user->getId() );

            } else if (in_array( User::USER_ROLE_TEACHER, $userDTO->roles )) {
                $this->teacherManager->saveTeacher( $user->getId() );

            }


        }  catch (Exception $e){

            if ($e instanceof UniqueConstraintViolationException ) {

                throw new DataSourceException("Пользователь с такими данными уже есть");

            } elseif ($e instanceof ORMException){
                throw new DataSourceException("Ошибка вставки");
            }


            throw $e; //Rethrow it if you can't handle it here.
        }
        return $user->getId();




    }

    public function updateUserFromDTO(int $userId, SaveuserDTO $userDTO): ?int
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }

        return $this->saveUserFromDTO($user, $userDTO);
    }
    public function findUser(int $userId): ?User
    {
        /** @var UserRepository $userReposotory */
        $userReposotory = $this->entityManager->getRepository(User::class);
        /** @var User $user */
        $user = $userReposotory->find($userId);
        return $user;
    }

    public function findUserByLogin(string $login): ?User
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User|null $user */
        $user = $userRepository->findOneBy(['login' => $login]);

        return $user;
    }


    /**
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        return $userRepository->getUsers($page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
    }

    /**
     * @return User[]
     */
    public function getUsersByRole(string $role, int $page, int $perPage): array
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        return $userRepository->getUsersByRole($role, $page ?? self::PAGINATION_DEFAULT_PAGE, $perPage ?? self::PAGINATION_DEFAULT_PER_PAGE);
    }


}