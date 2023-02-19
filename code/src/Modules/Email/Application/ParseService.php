<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Application;

use Nikcrazy37\Hw13\Modules\Email\Application\Exception\NotEmailException;

class ParseService
{
    /**
     * @param $email
     * @return string
     * @throws NotEmailException
     */
    public static function getDomain($email): string
    {
        if (stripos($email, "@") === false) {
            throw new NotEmailException();
        }

        $expEmail = explode("@", $email);
        return array_pop($expEmail);
    }
}