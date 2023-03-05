<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\NewBusLoanPurpose;
use Dvizh\BankBusDTO\NewBusLoanType;
use App\Application\DTO\Bank\Otkritie\EnterApplication\BoolStringValue;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Product;
use App\Application\DTO\Bank\Otkritie\Id;
use App\Application\DTO\Bank\Otkritie\IdList;
use App\Application\DTO\Bank\Otkritie\SystemCode;
use App\Application\Exception\InvalidValueException;

class ProductFactory
{
    // На основе наших loanType и loanPurpose получаем тип продукта в Открытии
    public const MAPPING = [
        NewBusLoanPurpose::PRIMARY_HOUSING => [
            NewBusLoanType::STANDARD => Product::TYPE_NEW_BUILDING,
            NewBusLoanType::FAMILY => Product::TYPE_FAMILY_MORTGAGE_NEW_BUILDING,
            NewBusLoanType::MILITARY => Product::TYPE_MILITARY_MORTGAGE_NEW_BUILDING,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_NEW_BUILDING,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_NEW_BUILDING,
            NewBusLoanType::IT => null,
        ],
        NewBusLoanPurpose::SECONDARY_HOUSING => [
            NewBusLoanType::STANDARD => Product::TYPE_FLAT,
            NewBusLoanType::FAMILY => Product::TYPE_FAMILY_MORTGAGE_FLAT,
            NewBusLoanType::MILITARY => Product::TYPE_MILITARY_MORTGAGE_FLAT,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_FLAT,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_FLAT,
            NewBusLoanType::IT => null,
        ],
        NewBusLoanPurpose::COUNTRY_HOUSE => [
            NewBusLoanType::STANDARD => Product::TYPE_RESIDENTIAL_BUILDING,
            NewBusLoanType::FAMILY => Product::TYPE_RESIDENTIAL_BUILDING,
            NewBusLoanType::MILITARY => Product::TYPE_RESIDENTIAL_BUILDING,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_RESIDENTIAL_BUILDING,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_RESIDENTIAL_BUILDING,
            NewBusLoanType::IT => null,
        ],
        NewBusLoanPurpose::APARTMENTS => [
            NewBusLoanType::STANDARD => Product::TYPE_FLAT,
            NewBusLoanType::FAMILY => null,
            NewBusLoanType::MILITARY => null,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_FLAT,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_FLAT,
            NewBusLoanType::IT => null,
        ],
        NewBusLoanPurpose::STOCKROOM => null,
        NewBusLoanPurpose::COMMERCIAL_MORTGAGE => null,
        NewBusLoanPurpose::REFINANCE => [
            NewBusLoanType::STANDARD => Product::TYPE_REFINANCING_SECONDARY_MARKET,
            NewBusLoanType::FAMILY => Product::TYPE_FAMILY_MORTGAGE_REFINANCING_SECONDARY_MARKET,
            NewBusLoanType::MILITARY => Product::REFINANCING_MILITARY_MORTGAGES_SECONDARY_MARKET,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_REFINANCING_SECONDARY_MARKET,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_REFINANCING_SECONDARY_MARKET,
            NewBusLoanType::IT => null,
        ],
        NewBusLoanPurpose::REALTY_BAIL => [
            NewBusLoanType::STANDARD => Product::TYPE_FREE_METERS,
            NewBusLoanType::FAMILY => Product::TYPE_FREE_METERS,
            NewBusLoanType::MILITARY => Product::TYPE_FREE_METERS,
            NewBusLoanType::GOVBACKED_2020 => Product::TYPE_FREE_METERS,
            NewBusLoanType::TWO_DOCUMENT => Product::TYPE_FREE_METERS,
            NewBusLoanType::IT => null,
        ],
    ];

    public static function createByNewBusLoanTypePurposeAndSystemCode(
        NewBusLoanType $loanType,
        NewBusLoanPurpose $loanPurpose,
        SystemCode $systemCode
    ): Product {
        $productType = self::MAPPING[$loanPurpose->value][$loanType->value] ?? null;
        if (is_null($productType)) {
            throw new InvalidValueException(sprintf(
                'Некорректная связка LoanType: %s и LoanPurpose: %s',
                $loanType->extract(),
                $loanPurpose->extract()
            ));
        }

        $id = new Id();
        $id->content = $productType;
        $id->systemCode = $systemCode;
        $idList = new IdList([$id]);
        $product = new Product($idList);

        if ($loanType->value === NewBusLoanType::TWO_DOCUMENT) {
            $product->IS_Simp_Confirm = BoolStringValue::TRUE;
        }

        return $product;
    }
}
