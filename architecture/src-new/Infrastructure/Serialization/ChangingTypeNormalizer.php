<?php

declare(strict_types=1);

namespace App\Infrastructure\Serialization;

use App\Application\Serialization\ChangingTypeNormalizable;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Нормалайзер для DTO, которые меняют свою структуру в зависимости от данных
 * Например, Document в App\Bank\Otkritie\DTO\Response\DocumentList может быть как объектом типа Document, так и
 * массивом из этих объектов
 */
class ChangingTypeNormalizer implements DenormalizerInterface, NormalizerInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $result = [];
        foreach ($data as $item) {
            $result[] = $this->normalizer->denormalize($item, $type, $format, $context);
        }

        return $result;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return \is_a($type, ChangingTypeNormalizable::class, true) && is_array($data) && array_is_list($data);
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return null;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return false;
    }
}
