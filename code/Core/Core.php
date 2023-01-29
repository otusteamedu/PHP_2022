<?php

declare(strict_types=1);

namespace Core;

use Controller\ValidatorController;

class Core
{
    public function startup(): void
    {
        $validator = new ValidatorController();
        $validator->go();
    }
}
