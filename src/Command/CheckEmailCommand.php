<?php

namespace Command;

use Kirillov\EmailValidator\Storage\HostsStorage;
use Kirillov\EmailValidator\Validator\EmailValidator;

class CheckEmailCommand
{
    /** @var string[] */
    private array $hosts = ['itglobal.com', 'mail.ru'];

    public function __construct(
        private EmailValidator $emailValidator,
        private HostsStorage $hostsStorage
    ) { }

    public function execute(string $email): void
    {
        $this->hostsStorage->set($this->hosts);

        $isValid = $this->emailValidator->isValid($email) ? 'valid' : 'not valid';

        echo "Email $email is " . $isValid . "\n";
    }
}
