<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Gateway\Repository\ProfileRepositoryInterface;
use App\Domain\Entity\Deal;
use App\Domain\Entity\Profile;
use Doctrine\DBAL\Exception;
use Ramsey\Uuid\Uuid;

class ProfileCreator
{
    public function __construct(readonly private ProfileRepositoryInterface $profileRepository) {
    }

    /**
     * @throws Exception
     */
    public function getProfileByClientIdAndDeal(string $clientId, Deal $deal): Profile
    {
        $profile = $this->profileRepository->find([
            'internal_id' => Uuid::fromString($clientId),
            'deal' => $deal
        ]);
        if (\is_null($profile)) {
            $profile = new Profile(Uuid::fromString($clientId), $this->profileRepository->nextId(), $deal);
            $this->profileRepository->save($profile);
        }
        return $profile;
    }
}
