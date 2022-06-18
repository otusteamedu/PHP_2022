<?php

namespace Otus\App\Factory;

use Otus\App\Mapper\CommentMapper;
use Otus\App\Mapper\CommentMapperIdentityMap;
use Otus\App\Mapper\CommentMapperInterface;
use Otus\Core\Database\Mapper\BaseMapper;

class CommentMapperFactory
{
    public static function make(): CommentMapperInterface
    {
        $baseMapper = new BaseMapper();
        $commentMapper = new CommentMapper($baseMapper);
        $identityMap = new CommentMapperIdentityMap($commentMapper);
        $identityMap->table = CommentMapperInterface::TABLE_NAME;
        return $identityMap;
    }
}