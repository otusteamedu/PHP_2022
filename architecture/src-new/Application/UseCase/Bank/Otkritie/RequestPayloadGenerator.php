<?php

declare(strict_types=1);

namespace App\Application\UseCase\Bank\Otkritie;

use App\Application\Factory\Bank\Otkritie\DocumentFactory;
use App\Domain\Entity\Bank;
use App\Domain\Entity\Document;
use Doctrine\Common\Collections\Collection;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Main;
use App\Infrastructure\Serialization\Bank\Otkritie\OtkritieEncoder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class RequestPayloadGenerator
{
    public function __construct(
        private readonly OtkritieEncoder $otkritieEncoder,
        private readonly LoggerInterface $bankRequestsLogger
    ) {
    }

    /**
     * @param Collection<string, Document> $documents
     * @return resource
     * @throws ExceptionInterface
     * @throws \JsonException
     */
    public function createEnterApplicationPayloadFile(Main $main, Collection $documents)
    {
        $data = $this->otkritieEncoder->getSerializer()->normalize($main);
        $payload = \json_encode($data, \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);

        $this->bankRequestsLogger->info('Контент запроса EnterApplication в банк ' . Bank::NAME_OTKRITIE, [
            'content' => $payload,
            'bank' => Bank::NAME_OTKRITIE,
            'api_method' => 'EnterApplication',
        ]);

        /** @psalm-suppress PossiblyFalseArgument с флагом \JSON_THROW_ON_ERROR payload не может быть false */
        $chunks = \explode(DocumentFactory::DOCUMENT_BODY_PLACEHOLDER, $payload);

        $file = \tmpfile();

        if ($file === false) {
            throw new \RuntimeException(Bank::NAME_OTKRITIE . ': не удалось создать временный файл для тела запроса');
        }

        /**
         * @psalm-suppress PossiblyFalseIterator в новых версиях php explode не возвращает false
         * @var string $chunk кроме строки здесь ничего не может быть, но psalm говорит, что может быть int
         */
        foreach ($chunks as $chunk) {
            if ($documents->containsKey($chunk)) {
                /** @var Document $document */
                $document = $documents->get($chunk);
                $documentContent = file_get_contents($document->getFilePath());
                if ($documentContent === false) {
                    throw new \RuntimeException(sprintf(
                        '%s: Не удалось получить контент документа id=%s',
                        Bank::NAME_OTKRITIE,
                        $document->getInternalId()->toString()
                    ));
                }
                \fwrite($file, \base64_encode($documentContent));
                continue;
            }
            \fwrite($file, $chunk);
        }

        return $file;
    }
}
