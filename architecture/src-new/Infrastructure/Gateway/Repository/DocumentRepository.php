<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Gateway\Repository\DocumentRepositoryInterface;
use App\Domain\Entity\Deal;
use App\Domain\Entity\Document;
use App\Domain\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Document>
 */
class DocumentRepository extends ServiceEntityRepository implements FindOrFailInterface, DocumentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function findByFilePath(string $filePath): ?Document
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT d
            FROM App\Entity\Document d
            WHERE d.filePath = :filePath'
        )->setParameter('filePath', $filePath);

        /** @var Document|null $document */
        $document = $query->getOneOrNullResult();
        return $document;
    }

    public function findByFilePathProfileAndDeal(string $filePath, Profile $profile, Deal $deal): ?Document
    {
        $query = $this->getEntityManager()->createQuery(
            '<...>'
        )
            ->setParameter('filePath', $filePath)
            ->setParameter('profile_uuid', $profile->getInternalId())
            ->setParameter('deal_uuid', $deal->getInternalId())
        ;

        /** @var Document|null $document */
        $document = $query->getOneOrNullResult();
        return $document;
    }

    public function findByDeal(Deal $deal): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            '<...>'
        )->setParameter('deal', $deal);

        /** @var Document[] $documents */
        $documents = $query->getResult();
        return $documents;
    }
}
