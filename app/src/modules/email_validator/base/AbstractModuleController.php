<?php

namespace nka\otus\modules\email_validator\base;

use nka\otus\core\AbstractController;

abstract class AbstractModuleController extends AbstractController
{
    public ?string $moduleName = 'email_validator';
}
