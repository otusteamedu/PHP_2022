<?php

declare(strict_types=1);

namespace Chernysh\EmailVerification\Service;

class EmailVerification implements ServiceInterface
{


    /**
     * @throws ServiceException
     */
    public function check(array $params): bool
    {

        if (!isset($params['emails'])) {
            throw new ServiceException('Необходимо указать параметр $emails');
        }

        $emails = trim($params['emails']);
        if (!$emails) {
            throw new ServiceException('Параметр $emails не может быть пустым');
        }

        foreach (explode(',', $emails) as $email) {
            $email = $this->validate($email);
            $domain = $this->getDomainName($email);
            $this->checkMx($domain);
        }

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