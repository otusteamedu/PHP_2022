<?php

declare(strict_types=1);

namespace Src\Sandwich\Infrastructure;

use Src\Sandwich\Application\Core\Core;

final class WebController
{
    public function __construct()
    {
        $application_core = new Core();

        $this->web_controller = $application_core->start()->get(WebController::class);
    }

    /**
     * @return array
     */
    public function startCooking(): array
    {
        return ['Веб версия в разработке' . "<br>"];
    }
}
