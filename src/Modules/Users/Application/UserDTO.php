<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Application;

class UserDTO
{
    public function __construct(
        public int    $id = 0,
        public string $name = '',
        public string $email = ''
    )
    {
    }
}