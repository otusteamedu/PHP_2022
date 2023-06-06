<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Controller;

use Nikcrazy37\Hw16\Libs\BaseController;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\View;
use Nikcrazy37\Hw16\Libs\Core\DI\DIContainer;
use Nikcrazy37\Hw16\Modules\Statement\Domain\User;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Statement;
use Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Queue\Sender;
use Nikcrazy37\Hw16\Modules\Statement\Domain\Exception\InvalidDate;
use DI\DependencyException;
use DI\NotFoundException;

class StatementController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->view = new View();
    }

    public function index()
    {
        $this->view->generate("statement/index.php");
    }

    /**
     * @throws InvalidDate
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function generate()
    {
        $result["name"] = $this->request->name;
        $result["dateFrom"] = $this->request->dateFrom;
        $result["dateTo"] = $this->request->dateTo;

        $container = DIContainer::build();
        $container->get(Sender::class)->execute(
                new User($result["name"]),
                new Statement($result["dateFrom"], $result["dateTo"])
        );

        $this->view->generate("statement/generate.php", $result);
    }
}