<?php

declare(strict_types=1);

namespace App\Bank\Common\Factory;

use App\Entity\Deal;
use App\Entity\Profile;
use App\Repository\ProfileRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ProfileFactory
{
    public function __construct(
        readonly private ProfileRepository $profileRepository,
        readonly private EntityManagerInterface $entityManager,
    ) {
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
            $this->entityManager->persist($profile);
            $this->entityManager->flush();
        }
        return $profile;
    }
}
