<?php

namespace Nsavelev\Hw4\App;

use Nsavelev\Hw4\App\Interfaces\AppInterface;
use Nsavelev\Hw4\Http\Controllers\StringValidator\StringValidatorController;

class App implements AppInterface
{
    /** @var StringValidatorController */
    private StringValidatorController $stringValidatorController;

    public function __construct()
    {
        $this->stringValidatorController = new StringValidatorController();
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        $response = $this->stringValidatorController->validateBrackets();
        
        return $response;
    }
}