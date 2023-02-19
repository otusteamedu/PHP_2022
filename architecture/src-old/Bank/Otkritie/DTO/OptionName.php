<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO;

enum OptionName: string
{
    /** ФИО инициатора подачи заявки */
    case PARTNER_NAME = 'Partner_name';
    /** e-mail инициатора заявки */
    case PARTNER_EMAIL = 'Partner_Email';
    /** Телефон инициатора заявки */
    case PARTNER_PHONE = 'Partner_Phone';
    /** Идентификатор офиса инициатора заявки */
    case PARTNER_ID = 'Partner_id';
    /** Регион нахождения предмета ипотеки */
    case PRODUCT_REGION = 'Product_Region';
    /** Размер мат.капа */
    case IS_MATERNITY_CAPITAL = 'IsMaternityCapital';
    /** Соотношение Кредит/Залог */
    case LTV = 'LTV';
    /** Размер комиссионного вознаграждения.  */
    case KV = 'kv';
    /** Тип занятости клиента */
    case CLIENT_ACTIVITY_TYPE = 'ClientActivityType';
    /** Степень родства с заемщиком */
    case BORROWER_RELATIVE_DEGREE = 'BorrowerRelative_Degree';
}
