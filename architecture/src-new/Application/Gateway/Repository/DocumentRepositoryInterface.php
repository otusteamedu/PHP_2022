<?php

namespace App\Application\Gateway\Repository;

use App\Domain\Entity\Deal;
use App\Domain\Entity\Document;
use App\Domain\Entity\Profile;

interface DocumentRepositoryInterface extends RepositoryInterface
{
    public function findByFilePathProfileAndDeal(string $filePath, Profile $profile, Deal $deal): ?Document;

    /**
     * @return Document[]
     */
    public function findByDeal(Deal $deal): array;
}