<?php

declare(strict_types=1);

namespace App\Infrastructure\Serialization\Bank\Otkritie;

use App\Infrastructure\Serialization\RubMoneyNormalizer;
use App\Infrastructure\Serialization\ChangingTypeNormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class OtkritieEncoder
{
    private Serializer $serializer;

    public function __construct()
    {
        $objectNormalizer = new ObjectNormalizer();
        $objectNormalizer->setSerializer(new Serializer([
            new ArrayDenormalizer(),
        ]));
        $this->serializer = new Serializer(
            [
                new ChangingTypeNormalizer($objectNormalizer),
                new RubMoneyNormalizer(),
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
