<?php
/**
 * Description of HasSearch.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Entity\Trait;

use JetBrains\PhpStorm\ArrayShape;

/**
 * HasSearch
 */

trait HasSearch
{
    public function getSearchIndex(): string
    {
        return  'otus_index';
    }

    public function getSearchType(): string
    {
        return $this->getTable() . '_index';
    }

    #[ArrayShape(['id' => "\int|null", 'url' => "\null|string", 'like' => "mixed", 'dislike' => "\int|null"])]
    public function toSearchArray(): array
    {
        return $this->convertToArray();
    }
}