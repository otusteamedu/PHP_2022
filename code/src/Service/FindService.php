<?php
declare(strict_types=1);


namespace Decole\Hw15\Service;


use Decole\Hw15\Core\DataMapper\User;
use Decole\Hw15\Core\DataMapper\UserMapper;
use Decole\Hw15\Core\Kernel;
use Klein\Response;

class FindService
{
    public function execute(int $id): User
    {
        try {
            $pdo = Kernel::connect();

            return (new UserMapper($pdo))->findById($id);
        } catch (\Throwable $exception) {
            (new Response())->json(['system error' => $exception->getMessage()]);
        }
    }
}