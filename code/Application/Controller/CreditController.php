<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Component\DataMapper\IdentityMap;
use App\Application\Component\Event\EventDispatcher;
use App\Application\Component\Form\ComplexElementCreator;
use App\Application\Component\Form\SimpleElementCreator;
use App\Application\Component\FormComponent\FormComponent;
use App\Application\Component\FormComponent\Validator\NameValidator;
use App\Application\Component\FormComponent\Validator\Passport\IssueCodeValidator;
use App\Application\Component\FormComponent\Validator\Passport\IssueDateValidator;
use App\Application\Component\FormComponent\Validator\Passport\NumberValidator;
use App\Application\Component\Http\{Request, Response};
use App\Domain\Event\CreditRequested;

class CreditController extends AbstractController
{
    public function requestFormPage(Request $request, EventDispatcher $dispatcher, IdentityMap $identityMap): Response
    {
        if ($request->get('submit') !== null) {

            $data = [
                'lastname' => $request->get('lastname'),
                'firstname' => $request->get('firstname'),
                'middlename' => $request->get('middlename'),
                'passport_number' => $request->get('pass_number'),
                'passport_who' => $request->get('pass_place_code'),
                'passport_when' => $request->get('pass_issue_date'),
            ];

            $validation_tree = $this->getCreditRequestTree(...$data);
            $validation_tree->process();

            $dispatcher->dispatch(new CreditRequested($data, $identityMap));

            return $this->render('templates/credit_success.html');
        }

        return $this->render('templates/credit_form.html');
    }

    private function getCreditRequestTree(
        string $lastname,
        string $firstname,
        string $middlename,
        string $passport_number,
        string $passport_who,
        string $passport_when
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

        $tree = $complex_ec->newTreeElement();
        $tree->add($user_name);
        $tree->add($user_passport);

        return $tree;
    }
}