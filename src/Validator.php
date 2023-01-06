<?php

namespace AKhakhanova\Hw4;

use Symfony\Component\HttpFoundation\Request;

class Validator
{
    public function checkRequestEmails(): array
    {
        $errors  = [];
        $request = Request::createFromGlobals();
        $emails  = $request->query->all();
        if (empty($emails)) {
            return ['No user email found in request parameters'];
        }

        foreach ($emails as $email) {
            if (!self::checkEmail($email)) {
                $errors[] = sprintf('Email "%s" has invalid format', $email);
            }
            if (!self::checkDomain($email)) {
                $errors[] = sprintf('Email "%s" has invalid server hostname', $email);
            }
        }

        return $errors;
    }

    public static function checkEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function checkDomain(string $email): bool
    {
        $hostname = substr($email, strpos($email, '@') + 1);

        return checkdnsrr($hostname);
    }
}
