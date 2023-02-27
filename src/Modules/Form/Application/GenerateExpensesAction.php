<?php

declare(strict_types=1);

namespace Eliasj\Hw16\Modules\Form\Application;

use Eliasj\Hw16\Modules\Form\Domain\GenerateExpenses;
use Eliasj\Hw16\Modules\Form\Domain\Queue;

class GenerateExpensesAction
{
    public function __construct(
        private string $date,
        private string $email
    ) {
    }

    public function run()
    {
        $expenses = GenerateExpenses::run();

        $data = [
            'message' => "За {$this->date} ваш расход составляет {$expenses} рублей",
            'email' => $this->email
        ];

        (new Queue())->sendMessage($data);
    }
}
