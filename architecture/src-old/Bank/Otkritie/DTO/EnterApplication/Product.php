<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use App\Bank\Otkritie\DTO\IdList;

class Product
{
    /** Квартира */
    public const TYPE_FLAT = 'С01.4.3.1.1';
    /** Новостройка */
    public const TYPE_NEW_BUILDING = 'С01.4.3.1.2';
    /** Рефинансирование (вторичный рынок) */
    public const TYPE_REFINANCING_SECONDARY_MARKET = 'С01.4.3.1.7';
    /** Рефинансирование (первичный рынок) */
    public const TYPE_REFINANCING_PRIMARY_MARKET = 'С01.4.3.1.10';
    /** Семейная ипотека. Квартира */
    public const TYPE_FAMILY_MORTGAGE_FLAT = 'С01.4.3.1.14';
    /** Семейная ипотека. Новостройка */
    public const TYPE_FAMILY_MORTGAGE_NEW_BUILDING = 'С01.4.3.1.13';
    /** Семейная ипотека. Рефинансирование (вторичный рынок) */
    public const TYPE_FAMILY_MORTGAGE_REFINANCING_SECONDARY_MARKET = 'С01.4.3.1.16';
    /** Семейная ипотека. Рефинансирование (первичный рынок) */
    public const TYPE_FAMILY_MORTGAGE_REFINANCING_PRIMARY_MARKET = 'С01.4.3.1.15';
    /** Военная ипотека. Квартира */
    public const TYPE_MILITARY_MORTGAGE_FLAT = 'С01.4.3.1.8';
    /** Военная ипотека. Новостройка */
    public const TYPE_MILITARY_MORTGAGE_NEW_BUILDING = 'С01.4.3.1.12';
    /** Рефинансирование военной ипотеки (вторичный рынок) */
    public const REFINANCING_MILITARY_MORTGAGES_SECONDARY_MARKET = 'С01.4.3.1.11';
    /** Ипотека + */
    public const TYPE_MORTGAGE_PLUS = 'С01.4.3.1.4';
    /** Свободные метры */
    public const TYPE_FREE_METERS = 'С01.4.3.1.3';
    /** Жилой дом */
    public const TYPE_RESIDENTIAL_BUILDING = 'С01.4.3.1.19';

    /**
     * Тип продукта хранится в IdLIst.Id.Content.
     */
    public IdList $IdList;

    /**
     * Ипотека по двум документам
     *  1 - да
     *  0 - нет
     */
    public BoolStringValue $IS_Simp_Confirm = BoolStringValue::FALSE;

    public function __construct(IdList $IdList)
    {
        $this->IdList = $IdList;
    }
}
