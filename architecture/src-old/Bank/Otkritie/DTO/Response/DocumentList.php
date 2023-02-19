<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

/**
 * Список документов в заявке.
 */
class DocumentList
{
    /**
     * @var Document|Document[]
     */
    public Document|array $Document;

    /**
     * @param Document|Document[] $Document
     */
    public function __construct(Document|array $Document)
    {
        $this->Document = $Document;
    }
}
