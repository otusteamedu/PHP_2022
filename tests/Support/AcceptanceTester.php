<?php

declare(strict_types=1);

namespace Tests\Support;

use App\App\Service\RandomStringGenerator;
use Faker\Factory;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function fillCorrectCardInfo(): void
    {
        $I = $this;
        $faker = Factory::create();
        $I->fillField('card_number', RandomStringGenerator::generateStringNumber(16));
        $I->fillField('cardholder', $faker->name . ' ' . $faker->lastName);
        $I->fillField('expiration_date', $faker->creditCardExpirationDateString);
        $I->fillField('cvv', RandomStringGenerator::generateStringNumber(3));
    }

    public function fillTestCardInfo(): void
    {
        $I = $this;
        $I->fillField('card_number', $_ENV['TEST_CARD_NUMBER']);
        $I->fillField('cardholder', $_ENV['TEST_CARDHOLDER']);
        $I->fillField('expiration_date', $_ENV['TEST_CARD_EXP_DATE']);
        $I->fillField('cvv', $_ENV['TEST_CARD_CVV']);
    }
}
