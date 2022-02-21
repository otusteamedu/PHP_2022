<?php

declare(strict_types=1);

namespace Command;

use Kirillov\DeezerAlbumInfo\Service\GetMainAlbumInfoService;
use Kirillov\DeezerAlbumInfo\Service\GetTracklistService;
use Service\PrepareFullAnswerService;

class PrintAlbumInfoCommand
{
    public function __construct(
        private GetMainAlbumInfoService $getMainAlbumInfoService,
        private GetTracklistService $getTrackListService,
        private PrepareFullAnswerService $prepareFullAnswerService
    ) { }

    public function execute(int $albumId): void
    {
        echo "Fetching data...\n\n";

        $albumData = $this->getMainAlbumInfoService->findInfoByAlbumId($albumId);
        $trackList = $this->getTrackListService->get($albumId);

        $answer = $this->prepareFullAnswerService->prepare($albumData, $trackList);
        echo $answer . PHP_EOL;;
    }
}