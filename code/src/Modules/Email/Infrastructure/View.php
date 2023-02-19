<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Infrastructure;

use Nikcrazy37\Hw13\Libs\AbstractView;

class View extends AbstractView
{
    public function __construct()
    {
        $this->viewPath = "/src/Modules/Email/Infrastructure/view/";
    }
}