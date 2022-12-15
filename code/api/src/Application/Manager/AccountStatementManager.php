<?php

declare(strict_types=1);

namespace App\Application\Manager;

use App\Api\Domain\Exception\EntityNotFoundException;
use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\AccountStatementDto;
use App\Application\Dto\Output\AccountStatementDto as OutputAccountStatementDto;
use App\Domain\Contract\AccountStatementDaoInterface;
use App\Domain\Contract\AccountStatementRepositoryInterface;
use App\Domain\Entity\AccountStatement;
use Symfony\Component\Uid\Uuid;

class AccountStatementManager implements AccountStatementManagerInterface
{
    public function __construct(
        private AccountStatementDaoInterface $accountStatementDao,
        private AccountStatementRepositoryInterface $accountStatementRepository
    ) {}

    public function create(AccountStatementDto $accountStatementDto): Uuid
    {
        $accountStatement = new AccountStatement();
        $accountStatement->setId($accountStatementDto->id);
        $accountStatement->setTextFromFields(
            $accountStatementDto->name,
            $accountStatementDto->dateBeginning,
            $accountStatementDto->dateEnding
        );
        return $this->accountStatementDao->create($accountStatement);
    }

    public function update(AccountStatementDto $accountStatementDto): void
    {
        $accountStatement =  $this->findEntity($accountStatementDto->id);
        $accountStatement->setTextFromFields(
            $accountStatementDto->name,
            $accountStatementDto->dateBeginning,
            $accountStatementDto->dateEnding
        );
        $this->accountStatementDao->update($accountStatement);
    }

    public function delete(Uuid $id): void
    {
        $accountStatement =  $this->findEntity($id);
        $this->accountStatementDao->delete($accountStatement);
    }

    public function find(Uuid $id): OutputAccountStatementDto
    {
        $accountStatement =  $this->findEntity($id);

        return $this->mapAccountStatementToDto($accountStatement);
    }

    public function findAll(): iterable
    {
        $outputAccountStatementsDto = [];
        $accountStatements = $this->accountStatementRepository->findAll();
        foreach ($accountStatements as $accountStatement) {
            $outputAccountStatementsDto[] = $this->mapAccountStatementToDto($accountStatement);
        }
        return $outputAccountStatementsDto;
    }

    private function findEntity(Uuid $id): AccountStatement
    {
        $accountStatement =  $this->accountStatementRepository->findById($id);
        if ($accountStatement === null) {
            throw new EntityNotFoundException('Не удалось найти выписку по счету с id = ' . $id);
        }

        return $accountStatement;
    }

    private function mapAccountStatementToDto(AccountStatement $accountStatement): OutputAccountStatementDto
    {
        $outputAccountStatementDto = new OutputAccountStatementDto();
        $outputAccountStatementDto->id = $accountStatement->getId();
        $outputAccountStatementDto->text = $accountStatement->getText();

        return $outputAccountStatementDto;
    }
}