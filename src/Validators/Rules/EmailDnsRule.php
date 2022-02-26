<?php

declare(strict_types=1);

namespace Philip\Otus\Validators\Rules;

class EmailDnsRule implements RuleInterface
{
    const CACHE_DNS_KEY = 'email:dns';

    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    private array $errors = [];

    public function make($value): bool
    {
        if (!(is_string($value))) {
            $this->errors[] = 'The email is invalid';
            return false;
        }

        $existsDns = '1';
        $emailPars = explode('@', $value);
        if (count($emailPars) !== 2) {
            $this->errors[] = 'email is invalid';
            return false;
        }
        [, $domain] = $emailPars;
        if ($this->redis->hExists(self::CACHE_DNS_KEY, $domain)) {
            $res = $this->redis->hGet(self::CACHE_DNS_KEY, $domain) === $existsDns;
        } else {
            $records = getmxrr($domain, $mx_records);
            $mx_records = array_filter($mx_records, fn($r) => !empty($r) && $r !== '0.0.0.0');
            $res = $records !== false && 0 !== count($mx_records);
            $this->redis->hSet(self::CACHE_DNS_KEY, $domain, $res);
        }
        if ($res === false) {
            $this->errors[] = 'dns is invalid';
        }
        return $res;
    }

    public function fail(): array
    {
        return $this->errors;
    }
}