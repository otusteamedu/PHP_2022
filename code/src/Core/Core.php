<?php

declare(strict_types=1);

namespace Kogarkov\Validator\Core;

use Kogarkov\Validator\Controller\ValidatorController;

class Core
{
    public function startup(): void
    {
        $validator = new ValidatorController();
        $validator->go();
    }
}
