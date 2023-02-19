<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Список документов в заявке.
 */
class DocumentList
{
    /**
     * @var Document[]
     */
    public array $Document;

    /**
     * Список документов.
     *
     * @param Document[] $Document
     */
    public function __construct(array $Document)
    {
        $this->Document = $Document;
    }
}
