<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class UserDTO
{

    #[Assert\NotBlank]
    #[Assert\Length(    min: 3,
                        max: 32,
                        minMessage: 'Логин должен быть не менее 3х символов',
                        maxMessage: 'Логин должен быть не более 32х символов'
                    )]
    public string $login;

    #[Assert\NotBlank]
    #[Assert\Length(max: 256)]
    public string $fullName;

    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public int $age;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    public string $email;

    public bool $isActive;

    /** @var string[] */
    public array $roles;

    public function __construct(array $data)
    {
        $this->login = $data['login'] ?? '';
        $this->fullName = $data['fullName'] ?? '';
        $this->age = $data['age'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->isActive = $data['isActive'] ?? false;
        $this->roles = $data['roles'] ?? [];
    }

    public static function fromEntity(User $user): self
    {
        return new self([
            'login' => $user->getLogin(),
            'fullName' => $user->getFullName(),
            'age' => $user->getAge(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'isActive' => $user->isActive(),
            'roles' => $user->getRoles(),
        ]);
    }
    /**
     * @throws JsonException
     */
    public static function fromRequest(Request $request): self
    {
        $roles = $request->request->get('roles') ?? $request->query->get('roles');
        $isActive =  $request->request->get('isActive') ?? $request->query->get('isActive');
        return new self(
            [

                'login' => $request->request->get('login') ?? $request->query->get('login'),
                'fullName' => $request->request->get('fullName') ?? $request->query->get('fullName'),
                'age' => $request->request->get('age') ?? $request->query->get('age'),
                'password' => $request->request->get('password') ?? $request->query->get('password'),
                'email' => $request->request->get('email') ?? $request->query->get('email'),
                'roles' => json_decode($roles, true, 512, JSON_THROW_ON_ERROR),
                'isActive' => $isActive === 'true' ? true : false,
            ]
        );
    }
}