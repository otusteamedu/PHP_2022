<?php
declare(strict_types=1);


namespace Decole\Hw15\Service;


use Decole\Hw15\Core\DataMapper\User;
use Decole\Hw15\Core\DataMapper\UserMapper;
use Decole\Hw15\Core\Kernel;
use Klein\Response;

class DeleteService
{
    public function execute(User $user): bool
    {
        try {
            $pdo = Kernel::connect();

            return (new UserMapper($pdo))->delete($user);
        } catch (\Throwable $exception) {
            (new Response())->json(['system error' => $exception->getMessage()]);
        }
    }
}