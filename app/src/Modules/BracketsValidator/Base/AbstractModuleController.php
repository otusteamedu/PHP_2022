<?php

namespace Nka\Otus\Modules\BracketsValidator\Base;


use Nka\Otus\Core\AbstractController;

abstract class AbstractModuleController extends AbstractController
{
    public ?string $moduleName = 'BracketsValidator';
}