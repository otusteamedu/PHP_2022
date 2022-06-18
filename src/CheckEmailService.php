<?php
declare(strict_types=1);

namespace Igor\Php2022;

use PHPUnit\Exception;

class CheckEmailService
{
    const MX_RECORD_NOT_FOUND = 'Не найдена MX запись';
    const LOCAL_TOO_LONG = 'Локальная часть адреса длиннее 64 символов';
    const NO_LOCAL = 'Локальная часть адреса отсутствует';
    const DOMAIN_TOO_LONG = 'Домен длиннее 255 символов';
    const INCORRECT_SYMBOL_IN_LOCAL_PART = 'Некорректный символ в локальной части адреса';
    const ALL_NUMERIC_TOP_LEVEL_DOMAIN_NAME = 'Домен верхнего уровня состоит из одних цифр';
    const INCORRECT_DOMAIN_NAME = 'Некорректное доменное имя';

    private string $error;

    public function isValid(string $email): bool
    {
        $this->error = '';
        [$local, $domain] = $this->splitEmail($email);

        try {
            $this->checkLocal($local);
            $this->checkDomain($domain);
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }

        return true;
    }

    private function checkLocal(string $local): void
    {
        if (strlen($local) > 64) {
            throw new \Exception(self::LOCAL_TOO_LONG);
        }

        if (strlen($local) == 0) {
            throw new \Exception(self::NO_LOCAL);
        }

        // если кавычек нет
        if (!preg_match('/^".*"$/', $local)) {
            if (!preg_match('/^[A-Za-z\d!#$%&\'*+-\/=?^_`{|}~.]+$/', $local)) {
                $this->error(self::INCORRECT_SYMBOL_IN_LOCAL_PART);
            }
        }
        // TODO контроль корректности при наличии кавычек
    }

    /**
     * @throws \Exception
     */
    private function checkDomain(string $domain): void
    {
        // не больше 255 символов
        if (strlen($domain) > 255) {
            $this->error(self::DOMAIN_TOO_LONG);
        }

        // если домен не в квадратных скобках
        if (!preg_match('/^\[.*\]$/', $domain)) {
            $this->checkDomainAllowedCharacters($domain);
            $this->checkMXRecords($domain);
        }
        // TODO добавить проверку на формат содержимого внутри квадратных скобок
        // это должен быть IPv4 или IPv6 адрес
    }

    private function checkDomainAllowedCharacters(string $domain): void
    {
        $dnsLabels = explode('.', $domain);

        $lastLabel = end($dnsLabels);
        if (preg_match("/^[0-9]+$/", $lastLabel)) {
            $this->error(self::ALL_NUMERIC_TOP_LEVEL_DOMAIN_NAME);
        }

        foreach ($dnsLabels as $label) {
            if (!preg_match("/^[A-Za-z0-9]([A-Za-z0-9\-]*[A-Za-z0-9])?$/", $label)) {
                $this->error(self::INCORRECT_DOMAIN_NAME);
            }
        }
    }

    private function checkMXRecords(string $domain): void
    {
        $hosts = [];
        if (!getmxrr($domain, $hosts)) {
            $this->error(self::MX_RECORD_NOT_FOUND);
        }
    }

    private function splitEmail($email)
    {
        $parts = explode('@', $email);
        $domain = array_pop($parts);
        $local = join('@', $parts);

        return [$local, $domain];
    }

    /**
     * @throws \Exception
     */
    private function error(string $msg)
    {
        throw new \Exception($msg);
    }

    public function getError(): string
    {
        return $this->error;
    }
}


