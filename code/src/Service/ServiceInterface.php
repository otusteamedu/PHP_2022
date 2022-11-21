<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification\Service;

interface ServiceInterface
{

    public function check(array $params): bool;

}