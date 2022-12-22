<?php

declare(strict_types=1);

namespace App\Application\Manager;

use App\Api\Domain\Exception\EntityNotFoundException;
use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\SaveAccountStatementDto;
use App\Application\Dto\Output\AccountStatementDto;
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

    public function create(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void
    {
        $accountStatement = new AccountStatement();
        $accountStatement->setId($id);
        $accountStatement->setTextFromFields(
            $saveAccountStatementDto->name,
            $saveAccountStatementDto->dateBeginning,
            $saveAccountStatementDto->dateEnding
        );
        $this->accountStatementDao->create($accountStatement);
    }

    public function update(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void
    {
        $accountStatement =  $this->findEntity($id);
        $accountStatement->setTextFromFields(
            $saveAccountStatementDto->name,
            $saveAccountStatementDto->dateBeginning,
            $saveAccountStatementDto->dateEnding
        );
        $this->accountStatementDao->update($accountStatement);
    }

    public function delete(Uuid $id): void
    {
        $accountStatement =  $this->findEntity($id);
        $this->accountStatementDao->delete($accountStatement);
    }

    public function find(Uuid $id): AccountStatementDto
    {
        $accountStatement = $this->findEntity($id);

        return $this->mapAccountStatementToDto($accountStatement);
    }

    public function findAll(): iterable
    {
        $accountStatementsDto = [];
        $accountStatements = $this->accountStatementRepository->findAll();
        foreach ($accountStatements as $accountStatement) {
            $accountStatementsDto[] = $this->mapAccountStatementToDto($accountStatement);
        }
        return $accountStatementsDto;
    }

    private function findEntity(Uuid $id): AccountStatement
    {
        $accountStatement =  $this->accountStatementRepository->findById($id);
        if ($accountStatement === null) {
            throw new EntityNotFoundException('Не удалось найти выписку по счету с id = ' . $id);
        }

        return $accountStatement;
    }

    private function mapAccountStatementToDto(AccountStatement $accountStatement): AccountStatementDto
    {
        $accountStatementDto = new AccountStatementDto();
        $accountStatementDto->id = $accountStatement->getId();
        $accountStatementDto->text = $accountStatement->getText();
        $accountStatementDto->cache = false;

        return $accountStatementDto;
    }
}