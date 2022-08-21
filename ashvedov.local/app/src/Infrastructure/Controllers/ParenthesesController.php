<?php

declare(strict_types=1);

namespace App\Src\Infrastructure\Controllers;

use App\Src\Domain\Parentheses\ParenthesesValidator;
use eftec\bladeone\BladeOne;

final class ParenthesesController
{
    private const PATH_TO_VIEW = __DIR__ . '/../../../src/Views';
    private const PATh_TO_VIEWS_CACHE = __DIR__ . '/../../../src/Bootstrap/cache';

    private ParenthesesValidator $parentheses_validator;

    public function __construct()
    {
        $this->parentheses_validator = new ParenthesesValidator(post_arr: $_POST);
    }

    /**
     * @return void
     */
    public function show(): void
    {
        try {
            $blade = new BladeOne(
                templatePath: self::PATH_TO_VIEW,
                compiledPath: self::PATh_TO_VIEWS_CACHE,
                mode: BladeOne::MODE_DEBUG
            );

            echo $blade->run(
                view: 'parentheses',
                variables: [
                    'validation_result' => false
                ],
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $result = $this->parentheses_validator->validate();

        if (! $result) {
            header(header: 'HTTP/2.0 400 Bad request');
            header(header: 'Content-Type: application/json; charset=utf-8');

            echo json_encode(['message' => 'Parenthesis structure is not valid']);
            exit();
        }

        try {
            $blade = new BladeOne(
                templatePath: self::PATH_TO_VIEW,
                compiledPath: self::PATh_TO_VIEWS_CACHE,
                mode: BladeOne::MODE_DEBUG
            );

            echo $blade->run(
                view: 'parentheses',
                variables: [
                    'validation_result' => true
                ],
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }
}
