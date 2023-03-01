<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Infrastructure;

use Nikcrazy37\Hw14\Libs\AbstractView;

class View extends AbstractView
{
    public function __construct()
    {
        $this->viewPath = "/src/Modules/Eatery/Infrastructure/view/";
    }
}