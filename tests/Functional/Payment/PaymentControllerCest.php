<?php

declare(strict_types=1);

namespace Test\Functional\Payment;

use App\App\Service\RandomStringGenerator;
use App\Domain\Entity\Order;
use Codeception\Stub;
use Faker\Factory;
use src\App\Gateway\Payment\MMMPaymentSystemGateway;
use src\App\Gateway\Payment\PaymentSystemGatewayInterface;
use Tests\Support\FunctionalTester;

class PaymentControllerCest
{
    private \Faker\Generator $faker;
    private FunctionalTester $tester;
    private string $orderNumber;

    protected function _before() {
        $this->faker = Factory::create();
        
        $this->orderNumber = RandomStringGenerator::generateStringNumber(18);
        $em = $this->tester->grabService('em');
        $order = new Order($this->orderNumber);
        $em->persist($order);
        $em->flush();
    }
    public function tryChargeWithCorrectCard(FunctionalTester $I): void
    {
        $paymentGateway = Stub::construct(MMMPaymentSystemGateway::class, [], ['charge' => true]);
        $container = $I->grabService('container');
        $container->set(PaymentSystemGatewayInterface::class, $paymentGateway);

        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();
        $I->click('Submit');
        $I->see('Спасибо за покупку', 'h1');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => true]);
    }

    public function tryChargeWithIncorrectCardnumber(FunctionalTester $I): void
    {
        $cardNumberLessThan16Digests = RandomStringGenerator::generateStringNumber(15);
        $cardNumberMoreThan16Digests = RandomStringGenerator::generateStringNumber(17);
        $cardNumberWithCharacters = RandomStringGenerator::generateStringNumber(7) . $this->faker->randomAscii . RandomStringGenerator::generateStringNumber(8);

        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#card_number', $cardNumberLessThan16Digests);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#card_number', $cardNumberMoreThan16Digests);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#card_number', $cardNumberWithCharacters);
        $I->click('Submit');
        $I->seeElement('#card_number .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
    }

    public function tryChargeWithIncorrectCardholder(FunctionalTester $I): void
    {
        $moreThanOneSpaceCardHolder = $this->faker->name . '  ' . $this->faker->lastName;
        $singleWordCardHolder = $this->faker->name;

        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#cardholder', $moreThanOneSpaceCardHolder);
        $I->click('Submit');
        $I->seeElement('#cardholder .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#cardholder', $singleWordCardHolder);
        $I->click('Submit');
        $I->seeElement('#cardholder .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
    }

    public function tryChargeWithIncorrectExpirationDate(FunctionalTester $I): void
    {
        $currentYearTwoNumbers = (new \DateTimeImmutable())->format('y');
        $currentMonthsTwoNumbers = (new \DateTimeImmutable())->format('m');

        $expDateWithoutSlash = $currentMonthsTwoNumbers . $currentYearTwoNumbers;
        $expDateExpiredYear = (new \DateTimeImmutable())->sub(new \DateInterval('P1Y'))->format('m/y');
        $expDateExpiredMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P1M'))->format('m/y');
        $expDateIncorrectMonth = strval(\random_int(13, 99)) . '/' . $currentYearTwoNumbers;

        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#exp_date', $expDateWithoutSlash);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#exp_date', $expDateExpiredYear);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#exp_date', $expDateExpiredMonth);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#exp_date', $expDateIncorrectMonth);
        $I->click('Submit');
        $I->seeElement('#exp_date .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
    }

    public function tryChargeWithIncorrectCVV(FunctionalTester $I): void
    {
        $cvv2Numbers = RandomStringGenerator::generateStringNumber(2);
        $cvv4Numbers = RandomStringGenerator::generateStringNumber(4);
        $cvvWithLetter = RandomStringGenerator::generateStringNumber(3) . RandomStringGenerator::randomEnglishAlphabetSting(1);
        $cvv3Letters = RandomStringGenerator::randomEnglishAlphabetSting(3);

        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
        $I->amOnPage('/payment');
        $I->fillCorrectCardInfo();

        $I->fillField('#cvv', $cvv2Numbers);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#cvv', $cvv4Numbers);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#cvv', $cvvWithLetter);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);

        $I->fillField('#cvv', $cvv3Letters);
        $I->click('Submit');
        $I->seeElement('#cvv .error');
        $I->seeInRepository(Order::class, ['orderNumber' => $this->orderNumber, 'isPaid' => false]);
    }
}