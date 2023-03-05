<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

use App\Application\DTO\Bank\Otkritie\IdList;
use App\Application\DTO\Bank\Otkritie\OptionList;

/**
 * Заявка в банк.
 */
class Application
{
    /**
     * Необязательно для создания заявки, обязательно для доработки и т.д.
     */
    public IdList $IdList;

    /**
     *  Канал продаж, обычно заполняется на стороне банка, если нет каких-то доп. критериев. Можно не заполнять.
     */
    public ?SourceChannel $SourceChannel;

    public AgreementList $AgreementList;
    /**
     * Продукт
     */
    public Product $Product;
    /**
     * Офис банка, куда отправляется заявка.
     */
    public RegistrationBranch $RegistrationBranch;
    /**
     * перечень дополнительной информации по заявке
     */
    public ?OptionList $OptionList;
    /**
     * Комментарий к заявке
     */
    public ?string $Comment = null;

    public function __construct(
        IdList $IdList,
        AgreementList $AgreementList,
        Product $Product,
        ?RegistrationBranch $RegistrationBranch,
        ?OptionList $OptionList
    ) {
        $this->IdList = $IdList;
        $this->AgreementList = $AgreementList;
        $this->Product = $Product;
        if (!is_null($RegistrationBranch)) {
            $this->RegistrationBranch = $RegistrationBranch;
        }
        if (!is_null($OptionList)) {
            $this->OptionList = $OptionList;
        }
    }
}
