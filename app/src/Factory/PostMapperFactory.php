<?php

namespace Otus\App\Factory;

use Otus\App\Mapper\PostMapper;
use Otus\Core\Database\Mapper\BaseMapper;

class PostMapperFactory
{
    public static function make(): PostMapper
    {
        $baseMapper = new BaseMapper();
        return new PostMapper($baseMapper);
    }
}