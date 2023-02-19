<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Deal;
use App\Entity\Document;
use App\Entity\Profile;
use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Dvizh\BankBusDTO\FileData;
use Dvizh\ParallelDownloaderBundle\DownloadManager;
use Ramsey\Uuid\Uuid;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Сервис для скачивания документов и конвертирования их подходящий для банков формат
 */
class DocumentHandler
{
    private DownloadManager $downloadManager;
    private FileConverter $fileConverter;
    private EntityManagerInterface $entityManager;
    private string $downloadFolderPath;
    private Filesystem $filesystem;
    private DocumentRepository $documentRepository;

    public function __construct(
        string $downloadFolderPath,
        DownloadManager $downloadManager,
        FileConverter $fileConverter,
        EntityManagerInterface $entityManager,
        DocumentRepository $documentRepository,
        Filesystem $filesystem
    ) {
        $this->downloadManager = $downloadManager;
        $this->fileConverter = $fileConverter;
        $this->entityManager = $entityManager;
        $this->downloadFolderPath = $downloadFolderPath;
        $this->filesystem = $filesystem;
        $this->documentRepository = $documentRepository;
    }

    /**
     * Скачивает документы, переданные в $fileCollection, формирует DTO с путями к этим файлам, сохраняет их в БД и
     * возвращает их
     *
     * @param FileData[] $fileCollection
     * @return Document[]
     * @throws \Throwable
     */
    public function downloadAndReturnProfileDocuments(
        Deal $deal,
        Profile $profile,
        array $fileCollection,
        bool $removeExistingDocs = false,
        bool $splitPDF = false
    ): array {
        if (\count($fileCollection) === 0) {
            return [];
        }

        if ($removeExistingDocs) {
            $oldDocuments = $profile->getDocuments();
            foreach ($oldDocuments as $document) {
                $this->entityManager->remove($document);
            }
            $this->entityManager->flush();
        }

        $newFiles = [];

        // формируем список новых файлов, которые нужно скачать,
        foreach ($fileCollection as $fileData) {
            $newFiles[$fileData->uuid] = $fileData;
        }

        if (\count($newFiles) !== 0) {
            if (!$this->filesystem->exists($this->downloadFolderPath)) {
                $this->filesystem->mkdir($this->downloadFolderPath);
            }
            if (!$this->filesystem->exists($this->downloadFolderPath . '/' . $deal->getInternalId()->toString())) {
                $this->filesystem->mkdir($this->downloadFolderPath . '/' . $deal->getInternalId()->toString());
            }

            $this->downloadManager->download(
                array_map(function (FileData $fileData) {
                    return $fileData->location['download_url'];
                }, $newFiles),
                $deal->getInternalId()->toString()
            );
        }

        // Для дальнейшего сжатия конвертируем все загруженные PDF в jpeg
        if ($splitPDF) {
            $newFiles = $this->splitPDFToImagesAndReturnFileCollection(
                $fileCollection,
                $this->downloadFolderPath . '/' . $deal->getInternalId()->toString()
            );
        }

        $fileNames = scandir($this->downloadFolderPath . '/' . $deal->getInternalId()->toString());
        if ($fileNames === false) {
            throw new \RuntimeException(sprintf(
                'Не удалось получить список документов в папке %s/%s',
                $this->downloadFolderPath,
                $deal->getInternalId()->toString()
            ));
        }

        $documents = [];

        // формируем список сущностей Document для дальнейшей работы
        foreach ($fileNames as $fileName) {
            $fileData = $newFiles[$fileName] ?? null;
            if (\is_null($fileData)) {
                continue;
            }
            $filePath = $this->downloadFolderPath . '/' . $deal->getInternalId()->toString() . '/' . $fileName;
            if (!is_file($filePath)) {
                continue;
            }
            $document = $this->createDocumentByFileDataAndPath($fileData, $filePath);
            $document->setDeal($deal);
            $document->setProfile($profile);
            $this->entityManager->persist($document);
            $documents[] = $document;
        }
        $this->entityManager->flush();
        $this->entityManager->refresh($profile);
        $this->entityManager->refresh($deal);

        return $documents;
    }

    /**
     * @param Deal $deal
     * @param Profile $profile
     * @param FileData[] $filesData
     * @return Collection<string, Document>
     * @throws \Throwable
     */
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
            $document = $this->documentRepository->findByInternalId($fileName);
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
     * Удаляет документы переданной сделки, как из БД, так и из файловой системы
     */
    public function removeDealDocuments(Deal $deal): void
    {
        $documents = $this->documentRepository->findByDeal($deal);
        foreach ($documents as $document) {
            $this->entityManager->remove($document);
        }
        $this->entityManager->flush();

        $folderPath = $this->downloadFolderPath . '/' . $deal->getInternalId()->toString();
        if ($this->filesystem->exists($folderPath)) {
            $this->filesystem->remove($folderPath);
        }
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
     * Генерирует entity Document на основе данных из FileData
     */
    private function createDocumentByFileDataAndPath(FileData $fileData, string $filePath): Document
    {
        $document = $this->documentRepository->findByInternalId($fileData->uuid);
        if (is_null($document)) {
            $document = new Document();
        }
        $document->setInternalId($fileData->uuid);
        $document->setType($fileData->type);
        $document->setCreatedAt(new \DateTimeImmutable());

        // т.к. документы могут быть самых разных форматов, то конвертируем в один
        $convertedFileData = $this->fileConverter->convert($filePath, $fileData->extension);
        $convertedFilePath = $convertedFileData['path'];
        $convertedFileExtension = $convertedFileData['extension'];
        $convertedFileSize = $convertedFileData['new_size'] ?? $fileData->size;

        $resultFileName = $fileData->originalName;
        if ($convertedFileExtension !== $fileData->extension) {
            $resultFileName = str_replace('.' . $fileData->extension, '.' . $convertedFileExtension, $resultFileName);
        }
        $document->setOriginalFileName($resultFileName);
        // сюда сохраняем итоговый файл
        $document->setFilePath($convertedFilePath);
        $document->setSize($convertedFileSize);
        $document->setExtension($convertedFileExtension);

        return $document;
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

    /**
     * Проходится по всем PDF файлам в папке, генерирует из них JPEG изображения, исходные PDF файлы удаляет
     * @param array<FileData> $fileCollection
     * @return  array<FileData>
     * @throws PdfDoesNotExist
     */
    private function splitPDFToImagesAndReturnFileCollection(array $fileCollection, string $folderPath): array
    {
        $newFileDataCollection = [];
        foreach ($fileCollection as $fileData) {
            if (\strtolower($fileData->extension) !== 'pdf') {
                $newFileDataCollection[$fileData->uuid] = $fileData;
                continue;
            }

            $filePath = $folderPath . '/' . $fileData->uuid;
            if (!\is_file($filePath)) {
                continue;
            }

            $imagePaths = $this->fileConverter->convertPdfToJpeg($filePath, $folderPath, $fileData->uuid);
            foreach ($imagePaths as $key => $imagePath) {
                $uuid = Uuid::uuid4()->toString();
                $this->filesystem->rename($imagePath, $folderPath . '/' . $uuid, true);
                $filesize = \filesize($folderPath . '/' . $uuid);
                if ($filesize === false) {
                    throw new \RuntimeException('Не удалось получить размер файла ' . $folderPath . '/' . $uuid);
                }
                $newFileDataCollection[$uuid] = new FileData(
                    $fileData->type,
                    $uuid,
                    \explode('.', $fileData->originalName)[0] . $key . '.jpeg',
                    'jpeg',
                    $filesize,
                    []
                );
            }
            $this->filesystem->remove($filePath);
        }

        return $newFileDataCollection;
    }
}
