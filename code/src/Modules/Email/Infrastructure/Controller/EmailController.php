<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Infrastructure\Controller;

use Nikcrazy37\Hw13\Modules\Email\Application\ParseService;
use Nikcrazy37\Hw13\Modules\Email\Domain\Email\Email;
use Nikcrazy37\Hw13\Modules\Email\Domain\Email\EmailName;
use Nikcrazy37\Hw13\Modules\Email\Domain\Email\EmailDomain;
use Nikcrazy37\Hw13\Libs\BaseController;
use Nikcrazy37\Hw13\Modules\Email\Infrastructure\View;

class EmailController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->view = new View();
    }

    public function index()
    {
        $this->view->generate("email/index.php");
    }

    public function check()
    {
        $email = $this->request->email;
        $arEmail = explode(PHP_EOL, trim($email));

        array_walk($arEmail, function ($email) {
            $domain = ParseService::getDomain($email);

            new Email(
                new EmailName($email),
                new EmailDomain($domain),
            );
        });

        $this->view->generate("email/success.php");
    }
}