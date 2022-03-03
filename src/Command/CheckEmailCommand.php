<?php

namespace Command;

use Kirillov\EmailValidator\Storage\HostsStorage;
use Kirillov\EmailValidator\Validator\EmailValidator;
use Service\GetEmailsService;

class CheckEmailCommand
{
    /** @var string[] */
    private array $hosts = ['itglobal.com', 'mail.ru'];

    public function __construct(
        private EmailValidator $emailValidator,
        private HostsStorage $hostsStorage,
        private GetEmailsService $getEmailsService
    ) { }

    public function execute(string $mail = ''): void
    {
        $this->hostsStorage->set($this->hosts);

        if (!empty($mail)) {
            $this->validate($mail);
            return;
        }

        $emails = $this->getEmailsService->get();
        foreach ($emails as $email) {
            $this->validate($email);
        }
    }

    private function validate(string $email): void
    {
        $isValid = $this->emailValidator->isValid($email) ? 'valid' : 'not valid';

        echo "Email $email is " . $isValid . PHP_EOL;
    }
}
