<?php

namespace Otus\App\Factory;

use Otus\App\Mapper\PostMapper;
use Otus\App\Mapper\PostMapperIdentityMap;
use Otus\App\Mapper\PostMapperInterface;
use Otus\Core\Database\Mapper\BaseMapper;

class PostMapperFactory
{
    public static function make(): PostMapperInterface
    {
        $baseMapper = new BaseMapper();
        $postMapper = new PostMapper($baseMapper);
        $identityMap = new PostMapperIdentityMap($postMapper);
        $identityMap->table = PostMapperInterface::TABLE_NAME;
        return $identityMap;
    }
}