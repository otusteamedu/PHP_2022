<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use App\Application\DTO\Bank\Otkritie\DocType;
use App\Application\DTO\Bank\Otkritie\Id;
use App\Application\DTO\Bank\Otkritie\IdList;
use App\Application\DTO\Bank\Otkritie\SystemCode;
use App\Application\Exception\InvalidValueException;
use Document\Application\DTO\Bank\Otkritie\EnterApplication\Document\Document;
use Dvizh\BankBusDTO\NewBusPassport;

class DocumentFactory
{
    /**
     * Идентификатор для обозначения мест в JSON, куда будут вставлено содержимое документов в base64.
     */
    public const DOCUMENT_BODY_PLACEHOLDER = 'document_content_placeholder';

    public const CATEGORY_MAPPING = [
        \App\Entity\Document::TYPE_AUTO_SIGNED_CREDIT_APP => Document::DOC_CATEGORY_QUESTIONNAIRE,
        \App\Entity\Document::TYPE_CREDIT_APP => Document::DOC_CATEGORY_QUESTIONNAIRE,
        \App\Entity\Document::TYPE_NDFL2_CERTIFICATE => Document::DOC_CATEGORY_PROOF_OF_INCOME,
        \App\Entity\Document::TYPE_PASSPORT => Document::DOC_CATEGORY_PASSPORT,
        \App\Entity\Document::TYPE_SNILS => Document::DOC_CATEGORY_PROOF_IDENTITY,
        \App\Entity\Document::TYPE_LABOUR_CONTRACT => Document::DOC_CATEGORY_CONFIRMATION_OF_EMPLOYMENT,
        \App\Entity\Document::TYPE_PENSION_CERTIFICATE => Document::DOC_CATEGORY_CONFIRMATION_OF_PENSION_EMPLOYMENT,
        \App\Entity\Document::TYPE_BIRTH_CERTIFICATE => Document::DOC_CATEGORY_PROOF_IDENTITY,
    ];

    public const TYPE_MAPPING = [
        \App\Entity\Document::TYPE_AUTO_SIGNED_CREDIT_APP => DocType::QUESTIONNAIRE,
        \App\Entity\Document::TYPE_CREDIT_APP => DocType::QUESTIONNAIRE,
        \App\Entity\Document::TYPE_NDFL2_CERTIFICATE => DocType::NDFL2,
        \App\Entity\Document::TYPE_PASSPORT => DocType::PASSPORT,
        \App\Entity\Document::TYPE_SNILS => DocType::SNILS,
        \App\Entity\Document::TYPE_LABOUR_CONTRACT => DocType::LABOUR_CONTRACT,
        \App\Entity\Document::TYPE_PENSION_CERTIFICATE => DocType::PENSION_CERTIFICATE,
        \App\Entity\Document::TYPE_BIRTH_CERTIFICATE => DocType::BIRTH_CERTIFICATE,
    ];

    public static function createByNewBusPassport(NewBusPassport $passport): Document
    {
        if (is_null($passport->unitCode)) {
            throw new InvalidValueException('Поле "Код подразделения" должно быть заполнено');
        }
        $document = new Document(Document::TYPE_IDENTIFICATION_DOC, DocType::PASSPORT);

        $document->category = Document::DOC_CATEGORY_PASSPORT;
        $document->Series = $passport->series;
        $document->Number = $passport->number;
        $document->IssueFrom = $passport->unitName;
        $document->IssueDate = $passport->obtainedAt->format('Y-m-d');
        $document->CodeFrom = $passport->unitCode;

        return $document;
    }

    /**
     * @throws \Exception
     */
    public static function createByNewBusDocumentEntity(\App\Entity\Document $documentEntity): Document
    {
        $externalId = $documentEntity->getExternalId();
        $docType = self::TYPE_MAPPING[$documentEntity->getType()] ?? null;
        if (\is_null($docType)) {
            if (\is_null($externalId)) {
                $docType = DocType::UNIVERSAL_CREATING_DOCUMENT;
            } else {
                $docType = DocType::UNIVERSAL_UPDATING_DOCUMENT;
            }
        }

        $document = new Document(Document::TYPE_DIGITAL, $docType);

        $documentId = new Id();
        $documentId->content = $documentEntity->getInternalId()->toString();
        $documentId->systemCode = SystemCode::BalancePlatform;
        $ids = [$documentId];

        if (!\is_null($externalId)) {
            $externalDocumentId = new Id();
            $externalDocumentId->content = $externalId;
            $externalDocumentId->systemCode = SystemCode::MSCRM;
            $ids[] = $externalDocumentId;
        }

        $document->IdList = new IdList($ids);
        // в Body должно хранится содержимое документа в Base64, но, чтобы не загружать память всем комплектом
        // документов, оставляю в JSON идентификаторы документов, которые в дальнейшем заменяются поочередно на
        // содержимое файлов
        $document->Body = self::DOCUMENT_BODY_PLACEHOLDER . $documentEntity->getInternalId()->toString() . self::DOCUMENT_BODY_PLACEHOLDER;
        $document->Name = self::removeForbiddenSymbols($documentEntity->getOriginalFileName());

        $category = self::CATEGORY_MAPPING[$documentEntity->getType()] ?? Document::DOC_CATEGORY_OTHER;
        $document->category = $category;

        return $document;
    }

    /**
     * Удаляет символы, недопустимые для Открытия в названиях файлов
     */
    private static function removeForbiddenSymbols(string $item): string
    {
        return str_replace(['?', '—', '–', '+', '№', '«', '»'], [''], $item);
    }
}
