<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\Services\MailValidator;

use Nsavelev\Hw5\Services\MailValidator\Interfaces\MailValidatorInterface;
use Nsavelev\Hw5\Services\MailValidator\Interfaces\ValidatorElementInterface;
use Nsavelev\Hw5\Services\MailValidator\ValidatorElements\DnsMxMailValidator;
use Nsavelev\Hw5\Services\MailValidator\ValidatorElements\RegexpMailValidator;

class MailValidatorService implements MailValidatorInterface
{
    /** @var array<ValidatorElementInterface> */
    private const validatorElements = [
        RegexpMailValidator::class,
        DnsMxMailValidator::class,
    ];

    /**
     * @inheritDoc
     */
    public function validate(array $mails): array
    {
        foreach (self::validatorElements as $element) {
            /** @var ValidatorElementInterface $validatorElement */
            $validatorElement = new $element();
            $validatedMails = $validatorElement->validate($mails);

            if (empty($validatedMails)) {
                break;
            }

            $validatedMails = array_values($validatedMails);
        }

        return $validatedMails;
    }
}