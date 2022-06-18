<?php

namespace Otus\App\Factory;

use Otus\App\Mapper\CommentMapper;
use Otus\Core\Database\Mapper\BaseMapper;

class CommentMapperFactory
{
    public static function make(): CommentMapper
    {
        $baseMapper = new BaseMapper();
        return new CommentMapper($baseMapper);
    }
}