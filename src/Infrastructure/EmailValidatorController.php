<?php

declare(strict_types=1);

namespace Src\Infrastructure;

use Src\Application\EngineApplication;
use Src\Application\Bootstrap\Configurator;
use Src\Application\Exceptions\WorldMxRecordsValidationException;

final class EmailValidatorController
{
    /**
     * @var Configurator
     */
    private Configurator $configurator;

    /**
     * @var EngineApplication
     */
    private EngineApplication $validate_email;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->configurator = new Configurator();

        $this->validate_email = $this->configurator->initialize()->get(EngineApplication::class);
    }

    /**
     * @param string $raw_email
     * @return void
     * @throws WorldMxRecordsValidationException|\Exception
     */
    public function validate(string $raw_email): void
    {
        $this->validate_email
            ->setEmail(email: $raw_email)
            ->simpleValidation()
            ->regexpValidation()
            ->mxRecordsValidation()
            ->worldMxRecordsValidation();
    }
}
