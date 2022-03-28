<?php

namespace hw4\modules\brackets_validator\base;


use hw4\core\AbstractController;

abstract class AbstractModuleController extends AbstractController
{
    public ?string $moduleName = 'brackets_validator';
}