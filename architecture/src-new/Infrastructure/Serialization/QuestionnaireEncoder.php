<?php

declare(strict_types=1);

namespace App\Infrastructure\Serialization;

use Dvizh\BankBusDTO\Serializer\SingleValueNormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Сериалайзер для DeliveryFullQuestionnaire
 */
class QuestionnaireEncoder
{
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(
            [
                new CentMoneyNormalizer(),
                new SingleValueNormalizer(),
                new BackedEnumNormalizer(),
                new PropertyNormalizer(
                    null,
                    null,
                    new PropertyInfoExtractor(
                        [new ReflectionExtractor()],
                        [new PhpStanExtractor(), new ReflectionExtractor()]
                    )
                ),
                new DateTimeNormalizer(),
                new ArrayDenormalizer(),
            ],
            [
                new JsonEncoder(
                    new JsonEncode([
                        JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
                    ])
                ),
            ]
        );
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }
}
