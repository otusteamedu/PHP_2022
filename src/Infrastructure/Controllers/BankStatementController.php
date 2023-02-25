<?php

declare(strict_types=1);

namespace Src\Infrastructure\Controllers;

use Twig\Error\{LoaderError, RuntimeError, SyntaxError};

final class BankStatementController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        twig()->display(name: 'bank-statement-form.html.twig');
    }

    public function generate()
    {
        //
    }
}
