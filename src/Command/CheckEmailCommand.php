<?php

namespace Command;

use Kirillov\EmailValidator\Storage\HostsStorage;
use Kirillov\EmailValidator\Validator\EmailValidator;
use Service\GetConfigDataService;
use ValueObject\ConfigFileName;

class CheckEmailCommand
{
    public function __construct(
        private EmailValidator $emailValidator,
        private HostsStorage $hostsStorage,
        private GetConfigDataService $getConfigDataService
    ) { }

    public function execute(string $mail = ''): void
    {
        $hosts = $this->getConfigDataService->get(ConfigFileName::HOSTS);
        $this->hostsStorage->set($hosts);
        if (!empty($mail)) {
            $this->validate($mail);
            return;
        }

        $emails = $this->getConfigDataService->get(ConfigFileName::EMAIL);
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
