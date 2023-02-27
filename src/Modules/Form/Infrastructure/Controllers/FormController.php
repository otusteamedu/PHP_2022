<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Infrastructure\Controllers;

use Eliasj\Hw16\App\BaseInfrastructure\BaseController;
use Eliasj\Hw16\App\Kernel\Response;
use Eliasj\Hw16\Modules\Form\Application\ConsumerAction;
use Eliasj\Hw16\Modules\Form\Application\GenerateExpensesAction;

class FormController extends BaseController
{
    private const PATH = __DIR__ . "/../templates/main.php";

    public static function listen()
    {
        ConsumerAction::run();
    }

    public function run(): string
    {
        return Response::render(self::PATH, []);
    }

    public function generate(): string
    {
        $email = $this->request->getPostParameter('email');
        $date = $this->request->getPostParameter('date');

        $action = new GenerateExpensesAction($date, $email);
        $action->run();

        return Response::render(self::PATH, [
            'message' => 'Данные будут сгенерированы и отправлены на указанный email'
        ]);
    }
}
