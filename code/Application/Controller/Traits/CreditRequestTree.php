<?php

declare(strict_types=1);

namespace App\Application\Controller\Traits;

use App\Application\Component\Form\ComplexElementCreator;
use App\Application\Component\Form\SimpleElementCreator;
use App\Application\Component\FormComponent\FormComponent;
use App\Application\Component\FormComponent\Validator\EmailValidator;
use App\Application\Component\FormComponent\Validator\NameValidator;
use App\Application\Component\FormComponent\Validator\Passport\IssueCodeValidator;
use App\Application\Component\FormComponent\Validator\Passport\IssueDateValidator;
use App\Application\Component\FormComponent\Validator\Passport\NumberValidator;

trait CreditRequestTree
{
    private function getCreditRequestTree(
        string $lastname,
        string $firstname,
        string $middlename,
        string $passport_number,
        string $passport_who,
        string $passport_when,
        string $email_callback
    ): FormComponent {

        $complex_ec = new ComplexElementCreator();
        $simple_ec = new SimpleElementCreator();

        $user_name = $complex_ec->newTreeElement();
        $user_name->add($simple_ec->newTreeElement($lastname, new NameValidator()));
        $user_name->add($simple_ec->newTreeElement($firstname, new NameValidator()));
        $user_name->add($simple_ec->newTreeElement($middlename, new NameValidator()));

        $user_passport = $complex_ec->newTreeElement();
        $user_passport->add($simple_ec->newTreeElement($passport_number, new NumberValidator()));

        $passport_data = $complex_ec->newTreeElement();
        $passport_data->add($simple_ec->newTreeElement($passport_who, new IssueCodeValidator()));
        $passport_data->add($simple_ec->newTreeElement($passport_when, new IssueDateValidator($passport_number)));

        $user_passport->add($passport_data);

        $email = $simple_ec->newTreeElement($email_callback, new EmailValidator());

        $tree = $complex_ec->newTreeElement();
        $tree->add($user_name);
        $tree->add($user_passport);
        $tree->add($email);

        return $tree;
    }
}