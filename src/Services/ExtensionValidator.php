<?php

declare(strict_types=1);

namespace Src\Services;

use RuntimeException;

final class ExtensionValidator
{
    /**
     * @return void
     */
    public function checkSocketExtension(): void
    {
        if (! extension_loaded(extension: 'sockets')) {
            throw new RuntimeException(message: 'The sockets extension is not loaded.');
        }
    }
}
