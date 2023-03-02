<?php

namespace App\Application\Gateway\NewLK;

use App\Domain\Entity\Deal;
use App\Domain\Entity\Document;
use App\Domain\Entity\Profile;
use Dvizh\BankBusDTO\FileData;
use Doctrine\Common\Collections\Collection;

interface DocumentDownloaderInterface
{
    /**
     * Скачивает документы, переданные в $fileCollection, формирует DTO с путями к этим файлам, сохраняет их в БД и
     * возвращает их
     *
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
    ): Collection;
}