<?php

declare(strict_types=1);

namespace Nsavelev\Hw5\App;

use Nsavelev\Hw5\App\Interfaces\AppInterface;
use Nsavelev\Hw5\Http\Controllers\CheckEmails\CheckEmailsController;

class App implements AppInterface
{
    /**
     * @return string
     * @throws \JsonException
     */
    public function handle(): string
    {
        $checkEmailsController = new CheckEmailsController();
        return $checkEmailsController->check();
    }
}