<?php

namespace Ppro\Hw6\Email;

use Ppro\Hw6\File;

class Validator
{
    protected $checkMX = false;
    public $filePath = '';
    public $validEmail = [];
    public $invalidEmail = [];
    public $arDNSMXResult = [];
    public $arDNSMXNotResult = [];

    function __construct(string $filePath, bool $checkMX = false)
    {
        $this->checkMX = $checkMX;
        $this->filePath = $filePath;
    }

    /** Проверка файла с Email с выводом результатов
     * @return array
     */
    public function validate():array
    {
        $this->validateFile();
        return [
          'VALID' => $this->validEmail,
          'INVALID' => $this->invalidEmail
        ];
    }

    /** Проверка файла с Email
     *
     */
    public function validateFile():void
    {
        $this->validEmail = [];
        $this->invalidEmail = [];
        $file = new File\Helper($this->filePath);
        foreach ($file->getRows() as $row) {
            if ($email = $this->validateEmail($row)) {
                $this->validEmail[] = $email;
            } else {
                $this->invalidEmail[] = $row;
            }
        }
    }

    /** Проверка строки Email //опционально по MX
     * @param string $email
     * @return string
     */
    public function validateEmail(string $email): string
    {
        $email = $this->validateEmailString($email);
        return ($email && $this->checkMX) ? $this->validateDomainMX($email) : $email;
    }

    /** Проверка строки Email фильтром валидации
     * @param string $email
     * @return string
     */
    public function validateEmailString(string $email): string
    {
        $sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($sanitized_email, FILTER_VALIDATE_EMAIL) ?: '';
    }

    /** Проверка Email по наличию MX записи домена
     * @param string $email
     * @return string
     */
    public function validateDomainMX(string $email): string
    {
        $domain = substr(strrchr($email, "@"), 1);
        if (in_array($email, $this->arDNSMXResult))
            return $email;
        if (in_array($email, $this->arDNSMXNotResult))
            return '';
        ($checkDomainDnsStatus = checkdnsrr($domain, 'MX')) ? $this->arDNSMXResult[] = $domain : $this->arDNSMXNotResult[] = $domain;
        return $checkDomainDnsStatus ? $email : '';
    }
}

