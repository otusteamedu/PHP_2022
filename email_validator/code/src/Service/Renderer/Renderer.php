<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Service\Renderer;


class Renderer
{
    public function render($path, $data):void
    {
        $sourceFile = realpath($path);
        if (!file_exists($sourceFile) && !is_file($sourceFile) && !is_readable($sourceFile)) {
            throw new \InvalidArgumentException("Unable to render page : `$sourceFile` because this file does not exist");
        }

        include($sourceFile);
    }
}