<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Deal;
use App\Entity\Document;
use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends ServiceEntityRepository<Document>
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function findByInternalId(string $internalId): ?Document
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT d
            FROM App\Entity\Document d
            WHERE d.internal_id = :internalId'
        )->setParameter('internalId', $internalId);

        /** @var Document|null $document */
        $document = $query->getOneOrNullResult();
        return $document;
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
            'SELECT d
            FROM App\Entity\Document d
            INNER JOIN d.profile p
            INNER JOIN d.deal d2
            WHERE d.filePath = :filePath and p.internal_id = :profile_uuid and d2.internal_id = :deal_uuid'
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
            'SELECT d
            FROM App\Entity\Document d
            WHERE d.deal = :deal'
        )->setParameter('deal', $deal);

        /** @var Document[] $documents */
        $documents = $query->getResult();
        return $documents;
    }

    /**
     * @return Document[]
     */
    public function findDocumentsForGPB(Deal $deal, UuidInterface $profileId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT d
            FROM App\Entity\Document d
            INNER JOIN d.documentGPB dgpb
            INNER JOIN d.profile p
            WHERE dgpb.checked = true
             AND dgpb.attachedToApp = false
             AND p.internal_id = :profileId
             AND d.deal = :deal'
        )
            ->setParameter('profileId', $profileId)
            ->setParameter('deal', $deal)
        ;
        return $query->getResult();
    }
}
