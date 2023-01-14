<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification\Service;

class EmailVerification
{


    /**
     * @throws ServiceException
     */
    public function check(string $email): bool
    {

        if (!$email) {
            throw new ServiceException('Необходимо указать параметр $email');
        }

        $email = trim($email);
        if (!$email) {
            throw new ServiceException('Параметр $email не может быть пустым');
        }

        $email = $this->validate($email);
        $domain = $this->getDomainName($email);
        $this->checkMx($domain);

        return true;
    }


    /**
     * @throws ServiceException
     */
    private function validate(string $email): string
    {
        if (!$email = filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ServiceException('Invalid email format');
        }

        return $email;
    }

    /**
     * @throws ServiceException
     */
    private function getDomainName(string $email): string
    {
        $explodeEmail = explode('@', $email);
        if (!isset($explodeEmail[1])) {
            throw new ServiceException('Domain name is empty');
        }

        return $explodeEmail[1];
    }

    /**
     * @throws ServiceException
     */
    private function checkMx(string $domain): void
    {
        getmxrr($domain, $res);
        if (!$res) {
            throw new ServiceException(sprintf('Domain «%s» not found', $domain));
        }
    }
}