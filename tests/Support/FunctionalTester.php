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
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    public function fillCorrectCardInfo(): void
    {
        $I = $this;
        $faker = Factory::create();
        $I->fillField('card_number', RandomStringGenerator::generateStringNumber(16));
        $I->fillField('cardholder', $faker->name . ' ' . $faker->lastName);
        $I->fillField('expiration_date', $faker->creditCardExpirationDateString);
        $I->fillField('cvv', RandomStringGenerator::generateStringNumber(3));
    }

    /**
     * Define custom actions here
     */
}
