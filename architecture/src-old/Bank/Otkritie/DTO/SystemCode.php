<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO;

/**
 * Список возможных SystemCode при работе с банком "Открытие"
 */
enum SystemCode: string
{
    /** Используется, как внешний (банковский) идентификатор сущностей */
    case MSCRM = 'MSCRM';
    /** Системный код нашего приложения */
    case BalancePlatform = 'BalancePlatform';
    case MSCRMUI = 'MSCRMUI';
    case CDI = 'CDI';
    case PFR = 'PFR';
    case BPM = 'BPM';
    case OPEN_API = 'OpenAPI';
    case DOC_ID = 'DocID';
    case TESSAECM = 'TESSAECM';
}
