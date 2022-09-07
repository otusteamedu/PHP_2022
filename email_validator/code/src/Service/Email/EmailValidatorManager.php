<?php
declare(strict_types=1);

namespace Mapaxa\EmailVerificationApp\Service\Email;

use Mapaxa\EmailVerificationApp\Service\Email\Factory\EmailValidatorFactory;

class EmailValidatorManager
{
    private $emails;
    private $availableValidators;

    public function __construct(array $emails, array $availableValidators)
    {
        $this->emails = array_map(function($email) {
            return trim($email);
        }, $emails);
        $this->availableValidators = $availableValidators;
    }

    public function getValidEmails()
    {
        foreach ($this->availableValidators as $validator) {
            if (class_exists($validator)) {
                $validator = EmailValidatorFactory::createEmailValidator($validator);
                $this->emails = $validator->validate($this->emails);
            }

        }
        return $this->emails;
    }

}

