<?php

namespace Dmitry\App\Validators;

class EmailValidator
{

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getInvalid(): array
    {
        if (!$this->hasValid()) {
            return $this->data;
        }

        $invalid = [];

        foreach ($this->validate() as $email => $valid) {
            if ($valid) {
                continue;
            }

            $invalid[] = $email;
        }

        return $invalid;
    }

    public function hasValid(): bool
    {
        $result = $this->validate();

        return in_array(true, $result);
    }

    public function validate(): array
    {
        $result = [];

        foreach ($this->data as $email) {
            $result[$email] = $this->valid($email);
        }

        return $result;
    }

    protected function valid(string $email): bool
    {
        return $this->validOnPattern($email) && $this->validOnDNS($email);
    }

    private function validOnPattern(string $email): bool
    {
        return preg_match("/^[a-z_.0-9]+@[a-z]+\.[a-z]+/i", $email);
    }

    private function validOnDNS(string $email): bool
    {
        preg_match("/(?<=@).+/i", $email, $match);

        return !empty($match) && checkdnsrr($match[0]);
    }
}