<?php

declare(strict_types=1);

namespace App\Application\Component\FormComponent\Validator\Passport;

use App\Application\Component\FormComponent\Validator\ValidatorInterface;
use DateTime;
use RuntimeException;

class IssueDateValidator implements ValidatorInterface
{
    public const MAX_FORM_ISSUE_DATE_GAP = 3;

    public const XXI_MIN_YEAR = 0;
    public const XX_MIN_YEAR = 97;
    public const XX_MAX_YEAR = 99;

    public function __construct(private readonly string $passport_number)
    {
    }

    public function validate(string $data): void
    {
        $this->validatePassportIssueDateFormat($data);
        $this->validatePassportSeriesYear();
    }

    private function validatePassportIssueDateFormat(string $data, string $format = 'Y-m-d'): void
    {
        $d = DateTime::createFromFormat($format, $data);

        if (!($d && $d->format($format) === $data)) {
            throw new RuntimeException('Wrong passport issue date.');
        }
    }

    private function validatePassportSeriesYear(): void
    {
        $series_year = self::getPassportSeries($this->passport_number);

        $max_issue_year = (int)date("y") + self::MAX_FORM_ISSUE_DATE_GAP;

        if (!(($series_year >= self::XXI_MIN_YEAR && $series_year <= $max_issue_year) ||
            ($series_year >= self::XX_MIN_YEAR && $series_year <= self::XX_MAX_YEAR))) {
            throw new RuntimeException('Wrong passport form issue year.');
        }
    }

    private static function getPassportSeries(string $passport_number): int
    {
        preg_match('/^\d{2}(\d{2})/', $passport_number, $matches);

        if (!isset($matches[1])) {
            throw new RuntimeException('Wrong passport form issue year.');
        }

        return (int)$matches[1];
    }
}