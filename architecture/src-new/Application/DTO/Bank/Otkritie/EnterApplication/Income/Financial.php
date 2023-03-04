<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication\Income;

use Money\Money;

/**
 * Информация о доходе.
 */
class Financial
{
    // Подтипы дохода
    /** Основное место работы (зарплата) */
    public const FINANCIAL_TYPE_SALARY = 1;
    /** Предпринимательская деятельность */
    public const FINANCIAL_TYPE_ENTREPRENEURIAL_ACTIVITY = 2;
    /** Совместительство (зарплата) */
    public const FINANCIAL_TYPE_PART_TIME_SALARY = 3;
    /** Пенсионные выплаты */
    public const FINANCIAL_TYPE_PENSION = 5;
    /** Доход от аренды */
    public const FINANCIAL_TYPE_RENTAL_INCOME = 6;
    /** Другое */
    public const FINANCIAL_TYPE_OTHER = 13;

    // Основания подтверждения
    /** 2НДФЛ */
    public const CONFIRM_DOC_NDFL_2 = '100000001';
    /** Справка по форме Банка/Справка в свободной форме */
    public const CONFIRM_DOC_BANK_CERTIFICATE = '100000000';
    /** Налоговая декларация о доходах физического лица по форме 3-НДФЛ */
    public const CONFIRM_DOC_NDFL_3 = '100000003';
    /** Документ не предоставляется (з/п начисления) */
    public const CONFIRM_DOC_WITHOUT_DOCS = '100000008';
    /** Выписка по счету клиента */
    public const CONFIRM_DOC_ACCOUNT_STATEMENT = '100000002';
    /** Данные управленческого учета */
    public const CONFIRM_DOC_ACCOUNTING_DATA = '100000004';
    /** Копия расчетных листов (pay checks) */
    public const CONFIRM_DOC_PAY_CHECKS = '100000005';
    /** Справка от работодателя подтверждающая стаж, должность и размер дохода */
    public const CONFIRM_DOC_EMPLOYER_CERTIFICATE = '100000006';
    /** Оригинал справки об оборотах по расчетному счету (при наличии)/счету физического лица */
    public const CONFIRM_DOC_ORIGINAL_TURNOVER_CERTIFICATE = '100000007';
    /** УСН (доходы) */
    public const CONFIRM_DOC_USN_INCOME = '100000009';
    /** УСН (доходы-расходы) */
    public const CONFIRM_DOC_USN_INCOME_EXPENSES = '100000010';
    /** ЕНВД */
    public const CONFIRM_DOC_ENVD = '100000011';
    /** Документ, подтверждающий пенсионные выплаты */
    public const CONFIRM_DOC_PENSION_CONFIRMATION = '100000012';
    /** Документ, подтверждающий получение арендной платы */
    public const CONFIRM_DOC_RENT_INCOME_CONFIRMATION = '100000013';

    /**
     * Признак основного дохода
     */
    public bool $primary;
    /**
     * Подтип дохода.
     */
    public int $FinancialType;
    /**
     * Размер заявленного дохода в рублях.
     */
    public Money $Amount;
    /**
     * Основание подтверждения.
     */
    public string $ConfirmDoc;

    public function __construct(bool $primary, int $FinancialType, Money $Amount, string $ConfirmDoc)
    {
        $this->primary = $primary;
        $this->FinancialType = $FinancialType;
        $this->Amount = $Amount;
        $this->ConfirmDoc = $ConfirmDoc;
    }
}
