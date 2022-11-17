<?php

declare(strict_types=1);

namespace Bundle\CheckEmailBundle\Test;

use Bundle\CheckEmailBundle\CheckEmailBundle;
use PHPUnit\Framework\TestCase;

class CheckEmailBundleTest extends TestCase
{
    public function testIsEmailValid(): void
    {
        $bad_emails = [
            'test@example',
            'John Doe <info@yandex.ru>',
            't@',
            '@example',
            'test.example',
            'test@examp@le',
            'test@[127.0.0.1]',
            'test@[IPv6:2001:0db8:85a3:0000:0000:8a2e:0370:7334]',
        ];

        $good_emails = [
            'info@google.com',
            'info@yandex.ru',
            'info+tag@yandex.ru',
        ];

        foreach ($bad_emails as $bad_email) {
            $this->assertFalse(CheckEmailBundle::isEmailValid($bad_email));
        }

        foreach ($good_emails as $good_email) {
            $this->assertTrue(CheckEmailBundle::isEmailValid($good_email));
        }
    }

    public function testCheckEmailsList(): void
    {
        $emails_list = 'amanbs@mail.ru' . PHP_EOL .
            'akjdbajwbd@gmail.com' . PHP_EOL .
            'akjwbdkjab@kjakjdba@jabd';

        $expected_result = 'amanbs@mail.ru is OK' . PHP_EOL;
        $expected_result .= 'akjdbajwbd@gmail.com is OK' . PHP_EOL;
        $expected_result .= 'akjwbdkjab@kjakjdba@jabd is BAD' . PHP_EOL;

        $this->assertEquals($expected_result, CheckEmailBundle::checkEmailsList($emails_list, PHP_EOL));
    }
}