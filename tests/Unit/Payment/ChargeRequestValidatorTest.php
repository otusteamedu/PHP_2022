<?php

declare(strict_types=1);

namespace Test\Unit\Payment;

use App\App\Payment\DTO\ChargeRequest;
use App\App\Service\ChargeRequestValidator;
use App\App\Service\RandomStringGenerator;
use Faker;
use PHPUnit\Framework\TestCase;

final class ChargeRequestValidatorTest extends TestCase
{
    private Faker\Generator $faker;
    private ChargeRequestValidator $chargeRequestValidator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->chargeRequestValidator = new ChargeRequestValidator();
        $this->faker = Faker\Factory::create();

    }

    public function testIncorrectCardNumber(): void
    {
        $cardNumberLessThan16Digests = $this->generateStringNumber(15);
        $cardNumberMoreThan16Digests = $this->generateStringNumber(17);
        $cardNumberWithCharacters = $this->generateStringNumber(7) . $this->faker->randomAscii . $this->generateStringNumber(8);
        $request = new ChargeRequest(
            '',
            $this->faker->name . ' ' . $this->faker->lastName,
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->card_number = $cardNumberLessThan16Digests;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_number = $cardNumberMoreThan16Digests;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_number = $cardNumberWithCharacters;
        self::assertFalse($this->chargeRequestValidator->isValid($request));
    }

    public function testIncorrectCardHolder(): void
    {
        $moreThanOneSpaceCardHolder = $this->faker->name . '  ' . $this->faker->lastName;
        $singleWordCardHolder = $this->faker->name;
        $shortListOfInappropriateSymbolsForCardHolder = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', ':', '"', '|', '<', '>', '?', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

        $request = new ChargeRequest(
            $this->generateStringNumber(16),
            '',
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->card_holder = $moreThanOneSpaceCardHolder;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_holder = $singleWordCardHolder;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        foreach ($shortListOfInappropriateSymbolsForCardHolder as $symbol) {
            $request->card_holder = $this->faker->name . $symbol . ' ' . $this->faker->lastName;
            self::assertFalse($this->chargeRequestValidator->isValid($request));
        }
    }

    public function testIncorrectExpirationDate(): void
    {
        $currentYearTwoNumbers = (new \DateTimeImmutable())->format('y');
        $currentMonthsTwoNumbers = (new \DateTimeImmutable())->format('m');

        $expDateWithoutSlash = $currentMonthsTwoNumbers . $currentYearTwoNumbers;
        $expDateExpiredYear = (new \DateTimeImmutable())->sub(new \DateInterval('P1Y'))->format('m/y');
        $expDateExpiredMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P1M'))->format('m/y');
        $expDateIncorrectMonth = strval(\rand(13, 99)) . '/' . $currentYearTwoNumbers;

        $request = new ChargeRequest(
            $this->generateStringNumber(16),
            $this->faker->name . ' ' . $this->faker->lastName,
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->card_expiration = $expDateWithoutSlash;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_expiration = $expDateExpiredYear;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_expiration = $expDateExpiredMonth;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->card_expiration = $expDateIncorrectMonth;
        self::assertFalse($this->chargeRequestValidator->isValid($request));
    }

    public function testIncorrectCVV(): void
    {
        $cvv2Numbers = $this->generateStringNumber(2);
        $cvv4Numbers = $this->generateStringNumber(4);
        $cvvWithLetter = $this->generateStringNumber(3) . RandomStringGenerator::randomEnglishAlphabetSting(1);
        $cvv3Letters = RandomStringGenerator::randomEnglishAlphabetSting(3);

        $request = new ChargeRequest(
            $this->generateStringNumber(16),
            $this->faker->name . ' ' . $this->faker->lastName,
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->cvv = $cvv2Numbers;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->cvv = $cvv4Numbers;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->cvv = $cvvWithLetter;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->cvv = $cvv3Letters;
        self::assertFalse($this->chargeRequestValidator->isValid($request));
    }

    public function testIncorrectOrderNumber(): void
    {
        $sumWithLetter = $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2) . RandomStringGenerator::randomEnglishAlphabetSting(1);
        $sumWithDotDelimiter = $this->generateStringNumber(4) . '.' . $this->generateStringNumber(2);
        $sumWithoutDelimiter = $this->generateStringNumber(6);
        $sum3NumbersInCents = $this->generateStringNumber(4) . ',' . $this->generateStringNumber(3);

        $request = new ChargeRequest(
            $this->generateStringNumber(16),
            $this->faker->name . ' ' . $this->faker->lastName,
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->sum = $sumWithLetter;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->sum = $sumWithDotDelimiter;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->sum = $sumWithoutDelimiter;
        self::assertFalse($this->chargeRequestValidator->isValid($request));

        $request->sum = $sum3NumbersInCents;
        self::assertFalse($this->chargeRequestValidator->isValid($request));
    }

    public function testIncorrectSum(): void
    {
        $orderNumberMoreThan17Characters = $this->generateStringNumber(17);

        $request = new ChargeRequest(
            $this->generateStringNumber(16),
            $this->faker->name . ' ' . $this->faker->lastName,
            $this->faker->creditCardExpirationDateString,
            $this->generateStringNumber(3),
            $this->generateStringNumber(10),
            $this->generateStringNumber(4) . ',' . $this->generateStringNumber(2)
        );

        $request->order_number = $orderNumberMoreThan17Characters;
        self::assertFalse($this->chargeRequestValidator->isValid($request));
    }

    private function generateStringNumber(int $numbersQuantity): string
    {
        $result = '';
        for ($i = 0; $i < $numbersQuantity; $i++) {
            $result .= $this->faker->randomDigit();
        }
        return $result;
    }
}