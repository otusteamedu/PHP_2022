<?php

declare(strict_types=1);

namespace Svatel\Code\Application\Services;

use Svatel\Code\Application\Dto\EmailDto;
use Svatel\Code\Domain\Email;

final class EmailService
{
    private function isIP(string $ip, int $type = null): bool
    {
        if ($type) {
            switch ($type) {
                case FILTER_FLAG_IPV4:
                    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
                case FILTER_FLAG_IPV6:
                    return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
            }
        }

        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    private function getRecords(string $ip, string $domain, array $mxhosts = []): string
    {
        if (!empty($mxhosts)) {
            $ip = array_shift($mxhosts);

            return $ip;
        }
        $domainRecord = null;

        if ($this->isIP($ip, FILTER_FLAG_IPV4)) {
            $domainRecord = dns_get_record($domain, DNS_A);
        }

        if ($this->isIP($ip, FILTER_FLAG_IPV6)) {
            $domainRecord = dns_get_record($domain, DNS_AAAA);
        }

        if (!empty($domainRecord)) {
            $ip = $domainRecord[0]['ip'];

            return $ip;
        }

        return '';
    }

    private function connectToServer(array $mxhosts, string $email, string $ip, string $domain): bool
    {
        if ($this->getRecords($ip, $domain, $mxhosts)) {
            $details = '';
            $ip = $this->getRecords($ip, $domain, $mxhosts);
            $connect = fsockopen($ip, 25);

            if ($connect) {
                $to = $email;

                if (preg_match('/^220/i', $out = fgets($connect, 1024))) {
                    fputs($connect, "HELO $ip\r\n");
                    $out = fgets($connect, 1024);
                    $details .= $out . "\n";

                    fputs($connect, "MAIL FROM: <$to>\r\n");
                    $from = fgets($connect, 1024);
                    $details .= $to . "\n";

                    fputs($connect, "RCPT TO: <$to>\r\n");
                    $to = fgets($connect, 1024);

                    fputs($connect, 'QUIT');
                    fclose($connect);
                    if (!preg_match('/^250/i', $from) || !preg_match('/^250/i', $to)) {
                        return false;
                    }

                    return true;
                }
            } else {
                return false;
            }
        }

        return false;
    }

    public function checkEmail(string $email): ?EmailDto
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mxhosts = [];
            $array = explode('@', $email());
            $domain = end($array);

            if ($this->isIP($domain)) {
                $ip = $domain;
            } else {
                getmxrr($domain, $mxhosts);
            }

            $res = $this->connectToServer($mxhosts, $email, $ip ?? '', $domain);
            $emailDomain = new Email($email);
            return new EmailDto($emailDomain, $res);
        }

        return null;
    }
}
