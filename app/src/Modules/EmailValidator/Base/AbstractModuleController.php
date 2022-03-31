<?php

namespace Nka\Otus\Modules\EmailValidator\Base;

use Nka\Otus\Core\AbstractController;

abstract class AbstractModuleController extends AbstractController
{
    public ?string $moduleName = 'EmailValidator';
}
