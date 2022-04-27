<?php
declare(strict_types=1);


namespace Decole\Hw15\Service;


use Decole\Hw15\Core\DataMapper\UserMapper;
use Decole\Hw15\Core\Kernel;
use Klein\Response;

class InstallService
{
    public function execute(): array
    {
        try {
            $pdo = Kernel::connect();
            $user = new UserMapper($pdo);

            $userData = array(
                'first_name' => 'Sergey',
                'last_name' =>'Galochkin',
                'email' => 'decole@rambler.ru',
                'approved' => true
            );

            // создание пользователя
            $userId = $user->insert($userData)->getId();

            return array_merge($userData, ['id' => $userId]);
        } catch (\Throwable $exception) {
            (new Response())->json(['system error' => $exception->getMessage()]);
        }
    }
}