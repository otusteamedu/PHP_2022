<?php

namespace nka\otus\modules\brackets_validator\base;


use nka\otus\core\AbstractController;

abstract class AbstractModuleController extends AbstractController
{
    public ?string $moduleName = 'brackets_validator';
}