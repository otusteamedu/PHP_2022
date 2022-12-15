<?php

declare(strict_types=1);

namespace App\Infrastructure\Consumer\CreateAccountStatement;

use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\AccountStatementDto;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Consumer implements ConsumerInterface
{
    public function __construct(
        private AccountStatementManagerInterface $accountStatementManager,
        private ValidatorInterface $validator
    ) {}


    public function execute(AMQPMessage $msg): int
    {
        $accountStatementDto = AccountStatementDto::createFromQueue($msg->getBody());
        $errors = $this->validator->validate($accountStatementDto);
        if ($errors->count() > 0) {
            return $this->reject((string)$errors);
        }

        sleep(3);

        $this->accountStatementManager->create($accountStatementDto);

        return self::MSG_ACK;
    }

    private function reject(string $error): int
    {
        echo "Incorrect message: $error";

        return self::MSG_REJECT;
    }
}