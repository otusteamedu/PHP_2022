<?php

declare(strict_types=1);

namespace Test\Acceptance\Payment;

use App\App\Service\RandomStringGenerator;
use App\Domain\Entity\Order;
use Codeception\Stub;
use Faker\Factory;
use src\App\Gateway\Payment\MMMPaymentSystemGateway;
use src\App\Gateway\Payment\PaymentSystemGatewayInterface;
use Tests\Support\AcceptanceTester;
use Tests\Support\FunctionalTester;

class PaymentControllerCest
{
    protected function _before() {
        $this->faker = Factory::create();
    }

    public function tryChargeWithCorrectCard(AcceptanceTester $I): void
    {
        $I->amOnPage('/payment');
        $I->fillTestCardInfo();
        $I->fillField('#card_number', $_ENV['test_card_number']);

        $I->click('Submit');
        $I->see('Спасибо за покупку', 'h1');
    }

    public function tryChargeWithIncorrectCardnumber(AcceptanceTester $I): void
    {
        $cardNumberLessThan16Digests = RandomStringGenerator::generateStringNumber(15);
        $cardNumberMoreThan16Digests = RandomStringGenerator::generateStringNumber(17);
        $cardNumberWithCharacters = RandomStringGenerator::generateStringNumber(7) . $this->faker->randomAscii . RandomStringGenerator::generateStringNumber(8);

        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#card_number', $cardNumberLessThan16Digests);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->see('Проверьте номер карты');

        $I->fillField('#card_number', $cardNumberMoreThan16Digests);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->see('Проверьте номер карты');

        $I->fillField('#card_number', $cardNumberWithCharacters);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->see('Проверьте номер карты');
    }

    public function tryChargeWithIncorrectCardholder(AcceptanceTester $I): void
    {
        $moreThanOneSpaceCardHolder = $this->faker->name . '  ' . $this->faker->lastName;
        $singleWordCardHolder = $this->faker->name;

        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#cardholder', $moreThanOneSpaceCardHolder);
        $I->click('Submit');
        $I->seeElement('#cardholder .error');
        $I->see('Проверьте корректность заполнения данных держателя карты');

        $I->fillField('#cardholder', $singleWordCardHolder);
        $I->click('Submit');
        $I->seeElement('#cardholder .error');
        $I->see('Проверьте корректность заполнения данных держателя карты');
    }

    public function tryChargeWithIncorrectExpirationDate(AcceptanceTester $I): void
    {
        $currentYearTwoNumbers = (new \DateTimeImmutable())->format('y');
        $currentMonthsTwoNumbers = (new \DateTimeImmutable())->format('m');

        $expDateWithoutSlash = $currentMonthsTwoNumbers . $currentYearTwoNumbers;
        $expDateExpiredYear = (new \DateTimeImmutable())->sub(new \DateInterval('P1Y'))->format('m/y');
        $expDateExpiredMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P1M'))->format('m/y');
        $expDateIncorrectMonth = strval(\random_int(13, 99)) . '/' . $currentYearTwoNumbers;

        
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#exp_date', $expDateWithoutSlash);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->see('Некорректная дата');

        $I->fillField('#exp_date', $expDateExpiredYear);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->see('Некорректная дата');

        $I->fillField('#exp_date', $expDateExpiredMonth);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->see('Некорректная дата');

        $I->fillField('#exp_date', $expDateIncorrectMonth);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->see('Некорректная дата');
    }

    public function tryChargeWithIncorrectCVV(AcceptanceTester $I): void
    {
        $cvv2Numbers = RandomStringGenerator::generateStringNumber(2);
        $cvv4Numbers = RandomStringGenerator::generateStringNumber(4);
        $cvvWithLetter = RandomStringGenerator::generateStringNumber(3) . RandomStringGenerator::randomEnglishAlphabetSting(1);
        $cvv3Letters = RandomStringGenerator::randomEnglishAlphabetSting(3);

        
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#cvv', $cvv2Numbers);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->see('Некорректные символы в поле CVV');

        $I->fillField('#cvv', $cvv4Numbers);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->see('Некорректные символы в поле CVV');

        $I->fillField('#cvv', $cvvWithLetter);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->see('Некорректные символы в поле CVV');

        $I->fillField('#cvv', $cvv3Letters);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->see('Некорректные символы в поле CVV');
    }
}