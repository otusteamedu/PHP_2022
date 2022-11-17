<?php

declare(strict_types=1);

namespace Eliasjump\StringsVerification\Controllers;

use function Eliasjump\StringsVerification\Functions\Validates\validateBraces;

class StringController extends BaseController
{
    public function run(): string
    {
        $string = $this->request->getPostParameter('string');
        if (!$string) {
            return $this->response(400);
        }

        if (!validateBraces($string)) {
            return $this->response(400);
        }

        return $this->response(200);
    }
}
