<?php

declare(strict_types=1);

namespace App\Infrastructure\Decorator;

use App\Application\Contract\AccountStatementManagerInterface;
use App\Application\Dto\Input\SaveAccountStatementDto;
use App\Application\Dto\Output\AccountStatementDto;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class AccountStatementManagerRedisCacheDecorator implements AccountStatementManagerInterface
{
    private const TAG_ACCOUNT_STATEMENT_LIST = 'account_statement_list';
    private const TAG_ACCOUNT_STATEMENT = 'account_statement_';

    public function __construct(
        private AccountStatementManagerInterface $accountStatementManager,
        private TagAwareCacheInterface $cache
    ) {}

    public function create(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void
    {
        $this->accountStatementManager->create($id, $saveAccountStatementDto);
        $this->cache->invalidateTags([
            self::TAG_ACCOUNT_STATEMENT_LIST
        ]);
    }

    public function update(Uuid $id, SaveAccountStatementDto $saveAccountStatementDto): void
    {
        $this->accountStatementManager->update($id, $saveAccountStatementDto);
        $this->cache->invalidateTags([
            self::TAG_ACCOUNT_STATEMENT_LIST,
            self::TAG_ACCOUNT_STATEMENT . (string) $id
        ]);
    }

    public function delete(Uuid $id): void
    {
        $this->accountStatementManager->delete($id);
        $this->cache->invalidateTags([
            self::TAG_ACCOUNT_STATEMENT_LIST,
            self::TAG_ACCOUNT_STATEMENT . (string) $id
        ]);
    }

    public function find(Uuid $id): ?AccountStatementDto
    {
        $tag = self::TAG_ACCOUNT_STATEMENT . (string) $id;
        if ($this->cache->hasItem($tag)) {
            return $this->cache->getItem($tag)->get();
        }

        $accountStatementDto = $this->accountStatementManager->find($id);

        $this->cache->get(
            $tag,
            function(ItemInterface $item) use ($accountStatementDto) {
                $result = clone $accountStatementDto;
                $result->cache = true;

                $item->tag(self::TAG_ACCOUNT_STATEMENT . (string) $accountStatementDto->id);

                return $result;
            }
        );

        return $accountStatementDto;
    }

    public function findAll(): iterable
    {
        if ($this->cache->hasItem(self::TAG_ACCOUNT_STATEMENT_LIST)) {
            return $this->cache->getItem(self::TAG_ACCOUNT_STATEMENT_LIST)->get();
        }

        $accountStatementsDto = $this->accountStatementManager->findAll();

        $this->cache->get(
            self::TAG_ACCOUNT_STATEMENT_LIST,
            function(ItemInterface $item) use ($accountStatementsDto) {
                $result = [];
                foreach ($accountStatementsDto as $accountStatementDto) {
                    $copyAccountStatementDto = clone $accountStatementDto;
                    $copyAccountStatementDto->cache = true;
                    $result[] = $copyAccountStatementDto;
                }

                $item->tag(self::TAG_ACCOUNT_STATEMENT_LIST);

                return $result;
            }
        );

        return $accountStatementsDto;
    }
}