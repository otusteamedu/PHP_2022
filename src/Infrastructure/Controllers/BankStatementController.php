<?php

declare(strict_types=1);

namespace Src\Infrastructure\Controllers;

use DI\{DependencyException, NotFoundException};
use Src\Domain\UseCases\PublishRequestBodyInQueue;
use Twig\Error\{LoaderError, RuntimeError, SyntaxError};
use Src\DTO\Domain\UseCases\PublishRequestBodyInQueueDTO;

final class BankStatementController
{
    /**
     * @var PublishRequestBodyInQueue
     */
    private PublishRequestBodyInQueue $use_case;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->use_case = app()->make(dependency: PublishRequestBodyInQueue::class);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        twig()->display(name: 'bank-statement-form.html.twig');
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \Exception
     */
    public function generate(): void
    {
        $dto = new PublishRequestBodyInQueueDTO(
            lastname: $_POST['lastname'],
            firstname: $_POST['firstname'],
            middle_name: $_POST['middle_name'],
            pass_number: $_POST['pass_number'],
            pass_place_code: $_POST['pass_place_code'],
            pass_issue_date: $_POST['pass_issue_date'],
            email_callback: $_POST['email_callback']
        );

        $this->use_case->publish(request_body: json_encode($dto));

        twig()->display(name: 'notice-acceptance-for-processing.html.twig');
    }
}
