<?php
declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Controller;

use Mapaxa\EmailVerificationApp\Service\Email\EmailValidatorManager;
use Mapaxa\EmailVerificationApp\Service\Renderer\Renderer;
use Mapaxa\EmailVerificationApp\HandBook\ConfigHandbook;

class EmailController
{

    public function index(): void
    {
        if (filter_has_var(INPUT_POST, 'email')) {

            $availableValidators = require_once ConfigHandbook::EMAIL_VALIDATORS_CONFIG;
            $stringWithEmails = filter_input(INPUT_POST, 'email');
            $emailsList = explode("\r\n", $stringWithEmails);

            $emailValidator = new EmailValidatorManager($emailsList, $availableValidators);
            $validEmails = $emailValidator->getValidEmails();
        }

        (new Renderer())->render('src/View/email/index.php', ['validEmails' =>$validEmails]);
    }
}