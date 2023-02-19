<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use App\Bank\Otkritie\DTO\DocType;
use App\Bank\Otkritie\DTO\IdList;

class Document
{
    /** Анкета */
    public const DOC_CATEGORY_QUESTIONNAIRE = 101;
    /** Паспорт */
    public const DOC_CATEGORY_PASSPORT = 102;
    /** Подтверждение дохода (найм) */
    public const DOC_CATEGORY_PROOF_OF_INCOME = 121;
    /** Подтверждение занятости (военнослужащие и т.п.) */
    public const DOC_CATEGORY_CONFIRMATION_OF_EMPLOYMENT = 127;
    /** Подтверждение занятости (Пенсионер) */
    public const DOC_CATEGORY_CONFIRMATION_OF_PENSION_EMPLOYMENT = 166;
    /** Подтверждение личности */
    public const DOC_CATEGORY_PROOF_IDENTITY = 134;
    /** Комплект документов по заявке (если не подходит под категории выше) */
    public const DOC_CATEGORY_OTHER = 138;

    public const TYPE_DIGITAL = 'T_DigitalDocument';
    public const TYPE_IDENTIFICATION_DOC = 'T_IdentificationDoc';

    public string $Type;

    public IdList $IdList;

    public string $Name;

    public string $Body;

    public int $category;

    /**
     * Только для паспорта
     * Серия паспорта гражданина РФ.
     */
    public string $Series;

    /**
     * Только для паспорта
     * Номер паспорта гражданина РФ.
     */
    public string $Number;

    /**
     * Только для паспорта
     * Кем выдан паспорт гражданина РФ.
     */
    public string $IssueFrom;

    /**
     * Только для паспорта
     * Дата выдачи паспорта гражданина РФ. (формат Y-m-d)
     */
    public string $IssueDate;
    /**
     * Тип документа
     */
    public DocType $docType;

    /**
     * Только для паспорта
     * Код подразделения, выдавшего паспорт РФ.
     */
    public string $CodeFrom;

    public function __construct(string $Type, DocType $docType)
    {
        $this->Type = $Type;
        $this->docType = $docType;
    }
}
