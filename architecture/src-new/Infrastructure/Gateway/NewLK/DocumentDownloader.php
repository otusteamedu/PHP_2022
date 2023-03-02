<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\NewLK;

use App\Application\Gateway\NewLK\DocumentDownloaderInterface;
use App\Domain\Entity\Deal;
use App\Domain\Entity\Document;
use App\Domain\Entity\Profile;
use App\Infrastructure\Gateway\Filesystem\FileConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Dvizh\BankBusDTO\FileData;
use Dvizh\ParallelDownloaderBundle\DownloadManager;
use App\Application\Gateway\Repository\DocumentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Сервис для скачивания документов и конвертирования их подходящий для банков формат
 */
class DocumentDownloader implements DocumentDownloaderInterface
{
    public function __construct(
        private readonly string $downloadFolderPath,
        private readonly DownloadManager $downloadManager,
        private readonly FileConverter $fileConverter,
        private readonly EntityManagerInterface $entityManager,
        private readonly DocumentRepositoryInterface $documentRepository,
        private readonly Filesystem $filesystem
    ) {
    }

    public function getProfileDocuments(
        Deal $deal,
        Profile $profile,
        array $filesData,
        bool $removeExistingDocs = false
    ): Collection {
        if (count($filesData) === 0) {
            return new ArrayCollection();
        }

        if ($removeExistingDocs) {
            $oldDocuments = $profile->getDocuments();
            foreach ($oldDocuments as $document) {
                $this->entityManager->remove($document);
            }
            $this->entityManager->flush();
        }
        $currentDocuments = $profile->getDocuments();
        $unexistedFiles = [];

        foreach ($filesData as $fileData) {
            if ($this->getDocumentEntityByUuid($fileData->uuid, $currentDocuments->toArray()) !== null) {
                continue;
            }
            $unexistedFiles[$fileData->uuid] = $fileData->location['download_url'];
        }
        if (count($unexistedFiles) !== 0) {
            if (!$this->filesystem->exists($this->downloadFolderPath)) {
                $this->filesystem->mkdir($this->downloadFolderPath);
            }
            if (!$this->filesystem->exists($this->downloadFolderPath . '/' . $deal->getInternalId()->toString())) {
                $this->filesystem->mkdir($this->downloadFolderPath . '/' . $deal->getInternalId()->toString());
            }
            $this->downloadManager->download($unexistedFiles, $deal->getInternalId()->toString());
        }

        $fileNames = scandir($this->downloadFolderPath . '/' . $deal->getInternalId()->toString());
        if ($fileNames === false) {
            throw new \Exception('Не удалось получить список документов в папке ' . $this->downloadFolderPath . '/' . $deal->getInternalId()->toString());
        }
        foreach ($fileNames as $fileName) {
            $filePath = $this->downloadFolderPath . '/' . $deal->getInternalId()->toString() . '/' . $fileName;
            if (!is_file($filePath)) {
                continue;
            }
            if ($this->documentRepository->findByFilePathProfileAndDeal($filePath, $profile, $deal) !== null) {
                continue;
            }
            $fileData = $this->getFileDataByUuid($fileName, $filesData);
            if (is_null($fileData)) {
                continue;
            }
            $document = $this->documentRepository->find($fileName);
            if (is_null($document)) {
                $document = new Document();
            }
            $document->setInternalId($fileName);
            $document->setExtension($fileData->extension);
            $document->setType($fileData->type);
            $document->setCreatedAt(new \DateTimeImmutable());
            $document->setDeal($deal);
            $document->setProfile($profile);

            $resultFileData = $this->fileConverter->convert($filePath, $fileData->extension);
            $resultFilePath = $resultFileData['path'];
            $resultFileExtension = $resultFileData['extension'];
            $resultFileSize = $resultFileData['new_size'] ?? $fileData->size;

            $resultFileName = $fileData->originalName;
            if ($resultFileExtension !== $fileData->extension) {
                $resultFileName = str_replace('.' . $fileData->extension, '.' . $resultFileExtension, $resultFileName);
            }
            $document->setOriginalFileName($resultFileName);
            // сюда сохраняем итоговый файл
            $document->setFilePath($resultFilePath);
            $document->setSize($resultFileSize);
            $this->entityManager->persist($document);
        }
        $this->entityManager->flush();
        $this->entityManager->refresh($profile);
        $this->entityManager->refresh($deal);

        return $profile->getDocuments();
    }

    /**
     * @param FileData[] $filesData
     */
    private function getFileDataByUuid(string $uuid, array $filesData): ?FileData
    {
        foreach ($filesData as $fileData) {
            if ($fileData->uuid === $uuid) {
                return $fileData;
            }
        }

        return null;
    }

    /**
     * @param Document[] $documents
     */
    private function getDocumentEntityByUuid(string $uuid, array $documents): ?Document
    {
        foreach ($documents as $document) {
            if ($document->getInternalId()->toString() === $uuid) {
                return $document;
            }
        }

        return null;
    }
}
