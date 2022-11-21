<?php

namespace Dmitry\App\Validators;

class EmailValidator
{

    public static function hasValidInArray(array $data): bool
    {
        $result = self::validateArray($data);

        return in_array(true, $result);
    }

    public static function validateArray(array $data): array
    {
        $result = [];

        foreach ($data as $email) {

            $result[$email] = self::validate($email);
        }

        return $result;
    }

    public static function validate(string $email): bool
    {
        return self::validateOnPattern($email) && self::validateOnDNS($email);
    }

    private static function validateOnPattern(string $email): bool
    {
        return preg_match("/^[a-z_.0-9]+@[a-z]+\.[a-z]+/i", $email);
    }

    private static function validateOnDNS(string $email): bool
    {
        preg_match("/(?<=@).+/i", $email, $match);

        return !empty($match) && checkdnsrr($match[0]);
    }
}