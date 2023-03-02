<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

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
