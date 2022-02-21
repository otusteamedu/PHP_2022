<?php

declare(strict_types=1);

namespace Service;

use JetBrains\PhpStorm\Pure;
use Kirillov\DeezerAlbumInfo\Dto\AlbumInfo;
use Kirillov\DeezerAlbumInfo\Dto\TrackDto;

class PrepareFullAnswerService
{
    /**
     * @param AlbumInfo $albumInfo
     * @param TrackDto[] $trackDtos
     * @return string
     */
    #[Pure] public function prepare(AlbumInfo $albumInfo, array $trackDtos): string
    {
        $answer = $albumInfo->getArtistName() . ' - ' . $albumInfo->getAlbumName() . ' - ' . $albumInfo->getReleaseDate();
        $answer .= "\n\n";
        foreach ($trackDtos as $trackDto) {
            $answer .= $trackDto->getPosition() . '. ' . $trackDto->getName() . ' (' . $trackDto->getDuration() . ")\n";
        }

        $answer .= "\nUPC: " . $albumInfo->getUpc() . "\n";
        $answer .= 'Label: ' . $albumInfo->getLabel() . "\n";
        $answer .= 'Deezer ID: ' . $albumInfo->getAlbumId() . "\n";
        $answer .= "\nTotal Duration: " . $albumInfo->getDuration();

        return rtrim($answer);
    }
}
