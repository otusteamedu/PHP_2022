<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Gateway\Repository\ProfileRepositoryInterface;
use App\Domain\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Dvizh\DoctrineBundle\Repository\FindOrFailInterface;
use Dvizh\DoctrineBundle\Repository\FindOrFailTrait;

/**
 * @extends ServiceEntityRepository<Profile>
 */
class ProfileRepository extends ServiceEntityRepository implements FindOrFailInterface, ProfileRepositoryInterface
{
    use FindOrFailTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    /**
     * @throws Exception
     */
    public function nextId(): int
    {
        // <...>
    }
}
