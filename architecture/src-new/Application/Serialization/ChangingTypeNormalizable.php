<?php

declare(strict_types=1);

namespace App\Application\Serialization;

/**
 * Интерфейс для DTO, структура которых меняется в зависимости от данных
 * Например, Document в App\Bank\Otkritie\DTO\Response\DocumentList может быть как объектом типа Document, так и
 * массивом из этих объектов
 */
interface ChangingTypeNormalizable
{
}
