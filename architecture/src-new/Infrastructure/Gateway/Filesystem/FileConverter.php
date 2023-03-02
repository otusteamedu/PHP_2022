<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Filesystem;

use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Spatie\PdfToImage\Pdf;

/**
 * Сервис для конвертации документов в подходящие для банков формат и разрешение
 */
class FileConverter
{
    /** Формат, в который нужно преобразовать картинки */
    private const DEFAULT_IMAGE_EXTENSION = 'jpeg';
    private const MAX_SIDE_SIZE = 1280;

    public function __construct(private readonly ImageManager $imageManager)
    {
    }


    /**
     * @param string $pathToPdf
     * @return array<string> список путей к получившимся картинкам
     * @throws PdfDoesNotExist
     */
    public function convertPdfToJpeg(string $pathToPdf, string $storedFolder, string $prefix): array
    {
        $pdf = new Pdf($pathToPdf);
        $pdf->setOutputFormat('jpeg');
        return $pdf->saveAllPagesAsImages($storedFolder, $prefix);
    }

    /**
     * @param string $path Путь до файла
     * @param string $extension Расширение файла
     * @return array{path: string, extension: string, new_size: ?int}
     */
    public function convert(string $path, string $extension): array
    {
        // не изменяем pdf документы. Библиотека некорректно конвертит pdf в изображения, например, для многостраничных
        // pdf на выходе получается картинка только для одной страницы
        if (\strtolower($extension) === 'pdf') {
            return [
                'path' => $path,
                'extension' => $extension,
                'new_size' => null,
            ];
        }

        try {
            $image = $this->imageManager->make($path);
        } catch (NotReadableException $exception) {
            return [
                'path' => $path,
                'extension' => $extension,
                'new_size' => null,
            ];
        }
        $image = $this->resizeImage($image);
        $image = $this->saveImage($image);

        return [
            'path' => $image->dirname . '/' . $image->basename,
            'extension' => $image->extension,
            'new_size' => (int) $image->filesize(),
        ];
    }

    /**
     * Приводит изображение к 720p, если ширина или длина больше 1280px. В этом случае уменьшает большую сторону до
     * 1280px, а меньшую уменьшает во столько же раз, что и большую
     */
    private function resizeImage(Image $image): Image
    {
        if ($image->getHeight() <= self::MAX_SIDE_SIZE && $image->getWidth() <= self::MAX_SIDE_SIZE) {
            return $image;
        }

        if ($image->getWidth() > $image->getHeight()) {
            $newHeight = $image->getHeight() * self::MAX_SIDE_SIZE / $image->getWidth();
            $image->resize(self::MAX_SIDE_SIZE, intval($newHeight));
        } else {
            $newWidth = $image->getWidth() * self::MAX_SIDE_SIZE / $image->getHeight();
            $image->resize(intval($newWidth), self::MAX_SIDE_SIZE);
        }

        return $image;
    }

    private function saveImage(Image $image): Image
    {
        $image->save($image->dirname . '/' . $image->filename . '.' . self::DEFAULT_IMAGE_EXTENSION);
        return $image;
    }
}
