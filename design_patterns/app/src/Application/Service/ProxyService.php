<?php

namespace Patterns\App\Application\Service;

use Patterns\App\ContainerFactory;

class ProxyService
{
    private const PIN_CODE = '1111';
    private const ISSUING_TYPE_LARGE = 'large';
    private const ISSUING_TYPE_SMALL = 'small';
    private const MONEY_ISSUING_TYPES = [
        self::ISSUING_TYPE_LARGE => MoneyIssuingLargeService::class,
        self::ISSUING_TYPE_SMALL => MoneyIssuingSmallService::class,
    ];

    private MoneyIssuingService $moneyIssuingService;

    public function giveOutStrategy(array $data): array
    {
        if (!$this->authenticate($data['pin'])) {
            throw new \Exception('Неверный пин-код', 403);
        }

        $this->moneyIssuingService = array_key_exists($data['type'], self::MONEY_ISSUING_TYPES)
            ? ContainerFactory::getContainer()->get(self::MONEY_ISSUING_TYPES[$data['type']])
            : ContainerFactory::getContainer()->get(self::MONEY_ISSUING_TYPES['large']);

        return $this->moneyIssuingService->giveOut($data['sum']);
    }

    private function authenticate(string $pin): bool
    {
        return $pin === self::PIN_CODE;
    }
}