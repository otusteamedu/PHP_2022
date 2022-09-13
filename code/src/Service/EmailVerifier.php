<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Exception\StringVerifierException;

class EmailVerifier implements StringVerifierInterface
{
    const VERIFIED_PATTERN = "/[^\p{L}0-9\@\.\-_]/u";

    // Ключ - домен, значение - результат проверки домена
    public function __construct(private array $verifiedDomains = []) {}

    public function verify(string $string): string
    {
        if (preg_match(self::VERIFIED_PATTERN, $string)) {
            throw new StringVerifierException('Не допустимые символы!');
        }

        $domain = substr($string, strpos($string, '@') + 1);
        if (!array_key_exists($domain, $this->verifiedDomains)) {
            $this->verifiedDomains[$domain] = (checkdnsrr(idn_to_ascii($domain), 'A') === true ? 'OK' : 'Домен: ' . $domain .' не найден!');
        }

        return $this->verifiedDomains[$domain];
    }
}

