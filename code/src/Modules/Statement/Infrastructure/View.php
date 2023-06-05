<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure;

use Nikcrazy37\Hw16\Libs\AbstractView;

class View extends AbstractView
{
    public function __construct()
    {
        $this->viewPath = "/src/Modules/Statement/Infrastructure/view/";
    }
}