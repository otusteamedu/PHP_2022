<?php declare(strict_types=1);

require_once "../vendor/autoload.php";

use Igor\Php2022\CheckEmailService;
use PHPUnit\Framework\TestCase;

final class CheckEmailServiceTest extends TestCase
{
    private $checkEmailService;

    protected function setUp(): void
    {
        $this->checkEmailService = new CheckEmailService();
    }

    public function testValid(): void
    {
        $this->assertTrue($this->checkEmailService->isValid('simple@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('example-indeed@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('very.common@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('disposable.style.email.with+symbol@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('other.email-with-hyphen@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('fully-qualified-domain@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('user.name+tag+sorting@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('x@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('test/test@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('" "@example.org'));
        $this->assertTrue($this->checkEmailService->isValid('"john..doe"@example.org'));
        $this->assertTrue($this->checkEmailService->isValid('mailhost!username@example.org'));
        $this->assertTrue($this->checkEmailService->isValid('"very.(),:;<>[]\".VERY.\"very@\\ \"very\".unusual"@example.com'));
        $this->assertTrue($this->checkEmailService->isValid('user%example.com@example.org'));
        $this->assertTrue($this->checkEmailService->isValid('user-@example.org'));
        $this->assertTrue($this->checkEmailService->isValid('postmaster@[123.123.123.123]'));
        $this->assertTrue($this->checkEmailService->isValid('postmaster@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370:7334]'));
    }

    public function testInvalid(): void
    {
        $this->assertFalse($this->checkEmailService->isValid('example@strange-example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::MX_RECORD_NOT_FOUND);

        $this->assertFalse($this->checkEmailService->isValid('Abc.example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::NO_LOCAL);

        $this->assertFalse($this->checkEmailService->isValid('A@b@c@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);

        $this->assertFalse($this->checkEmailService->isValid('a"b(c)d,e:f;g<h>i[j\k]l@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);

        $this->assertFalse($this->checkEmailService->isValid('just"not"right@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);

        $this->assertFalse($this->checkEmailService->isValid('this is"not\allowed@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);

        $this->assertFalse($this->checkEmailService->isValid('this\ still\"not\\allowed@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);

        $this->assertFalse($this->checkEmailService->isValid('1234567890123456789012345678901234567890123456789012345678901234+x@example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::LOCAL_TOO_LONG);

        $this->assertFalse($this->checkEmailService->isValid('i_like_underscore@but_its_not_allowed_in_this_part.example.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_DOMAIN_NAME);

        $this->assertFalse($this->checkEmailService->isValid('QA[icon]CHOCOLATE[icon]@test.com'));
        $this->assertEquals($this->checkEmailService->getError(), CheckEmailService::INCORRECT_SYMBOL_IN_LOCAL_PART);
    }
}