<?php
declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Controller;

use Mapaxa\EmailVerificationApp\Service\Email\EmailValidator;

class EmailController
{
    public function index(): void
    {

        if (filter_has_var(INPUT_POST, 'email')) {

            $stringWithEmails = filter_input(INPUT_POST, 'email');
            $emailsList = explode("\r\n", $stringWithEmails);

            $emailValidator = new EmailValidator($emailsList);
            $validEmails = $emailValidator->getValidEmails();
        }

        require_once ('src/View/email/index.php');
    }
}