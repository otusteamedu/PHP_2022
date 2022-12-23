<?php

declare(strict_types=1);

namespace Src;

use Src\Exceptions\EmailValidatorException;
use Src\Services\Converters\StringConverter;
use Src\Services\EmailValidatorService;

final class EmailValidator
{
    private EmailValidatorService $validator_service;
    private string|array $emails;

    /**
     * @param string|array $emails
     */
    public function __construct(string|array $emails)
    {
        $this->emails = $emails;
        $this->validator_service = new EmailValidatorService(emails: $emails);
    }

    /**
     * @return EmailValidator
     */
    public function validate(): EmailValidator
    {
        return new self($this->validator_service->isEmailValid());
    }

    /**
     * @return string
     * @throws EmailValidatorException
     */
    public function toJson(): string
    {
        try {
            return json_encode($this->emails);
        } catch (\Throwable $exception) {
            throw new EmailValidatorException(
                message: 'Method: ' . __METHOD__ . PHP_EOL
                . 'Error: ' . $exception->getMessage()
            );
        }
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $string_converter = new StringConverter(emails: $this->emails);
        return $string_converter->toString();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->emails;
    }
}
