<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5\Model;

use \Exception;

class EmailValidator
{
    private $email;
    private $domain;

    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function validate()
    {
        $this->prepareParam();

        if (!$this->validateName()) {
            throw new Exception('[ERROR] Incorrect email name!');
        }

        if (!$this->validateMx()) {
            throw new Exception('[ERROR] Incorrect email mx record!');
        }

        throw new Exception('[SUCCESS] Correct email!');
    }

    /**
     * @return void
     * @throws Exception
     */
    private function prepareParam()
    {
        $this->email = explode(PHP_EOL, trim($this->email));

        $this->domain = $this->getDomain();
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getDomain(): array
    {
        $arExpEmail = $domain = array();
        foreach ($this->email as $email) {
            if (stripos($email, "@") === false) {
                throw new Exception('[ERROR] One of the values is not email!');
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