<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class DateCardValidator extends ConstraintValidator
{
    public const PATTERN = '/^(?<month>\d{2})\/(?<year>\d{2})$/';

    /**
     * Checks whether a date is valid.
     *
     * @internal
     */
    public static function checkDate(int $month, int $year): bool
    {
        return checkdate($month, '01', $year);
    }

    /**
     * {@inheritdoc}
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof DateCard) {
            throw new UnexpectedTypeException($constraint, DateCard::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !$value instanceof \Stringable) {
            throw new UnexpectedValueException($value, 'string');
        }

        $value = (string) $value;

        if (!preg_match(static::PATTERN, $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(DateCard::INVALID_FORMAT_ERROR)
                ->addViolation();

            return;
        }

        if (!self::checkDate(
            $matches['month'] ?? $matches[2],
            $matches['year'] ?? $matches[1],
        )) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(DateCard::INVALID_DATE_ERROR)
                ->addViolation();
        }
    }
}
