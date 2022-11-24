<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5\Model;

use Nikcrazy37\Hw5\Exception\EmailValidateException;

class EmailValidator
{
    private $email;
    private $domain;

    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     * @throws EmailValidateException
     */
    public function validate(): string
    {
        $this->prepareParam();

        if (!$this->validateName()) {
            throw new EmailValidateException('[ERROR] Incorrect email name!');
        }

        if (!$this->validateMx()) {
            throw new EmailValidateException('[ERROR] Incorrect email mx record!');
        }

        return "[SUCCESS] Correct email!";
    }

    /**
     * @return void
     * @throws EmailValidateException
     */
    private function prepareParam()
    {
        $this->email = explode(PHP_EOL, trim($this->email));

        $this->domain = $this->getDomain();
    }

    /**
     * @return array
     * @throws EmailValidateException
     */
    private function getDomain(): array
    {
        $arExpEmail = $domain = array();
        foreach ($this->email as $email) {
            if (stripos($email, "@") === false) {
                throw new EmailValidateException('[ERROR] One of the values is not email!');
            }

            $arExpEmail[] = explode("@", $email);
        }

        foreach ($arExpEmail as $expEmail) {
            $domain[] = array_pop($expEmail);
        }

        return $domain;
    }

    /**
     * @return bool
     */
    private function validateName(): bool
    {
        foreach ($this->email as $email) {
            if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    private function validateMx(): bool
    {
        foreach ($this->domain as $domain) {
            if (!checkdnsrr(trim($domain))) {
                return false;
            }
        }

        return true;
    }
}