<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Contract\CreateRequestInterface;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\Value;
use RuntimeException;

/**
 * RedisService
 */
class RedisService
{
    private ?\Symfony\Component\HttpFoundation\Request $request;
    private Logic $logic;
    private CreateRequestInterface $createRequestDto;

    public function __construct(CreateRequestInterface $createRequestDto, Logic $logic)
    {
        $this->logic = $logic;
        $this->createRequestDto = $createRequestDto;
    }

    /**
     * @throws \JsonException
     *
     * example:
     */
    public function addEvent(): void
    {
        try {
            new Id($this->createRequestDto->getId());
            new value($this->createRequestDto->getValue());

            $this->logic->execute();
        } catch (\RuntimeException $e) {
            echo $e->getMessage();
        }
    }
}