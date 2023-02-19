<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Exception\InvalidValueException;
use App\Service\MoneyFormatter;
use Money\Currency;
use Money\Money;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Конвертация рублей в Money
 */
class RubMoneyNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): ?Money
    {
        if ($data === null) {
            return null;
        }

        if (!\is_numeric($data)) {
            throw new InvalidValueException('Значение для типа Money должно быть числовым значением');
        }

        return new Money(bcmul((string) $data, '100'), new Currency('RUB'));
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return Money::class === $type;
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        /** @var Money $object */
        return (float) MoneyFormatter::decimalFormat($object);
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Money;
    }
}
