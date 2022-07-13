<?php

namespace Mselyatin\Project15\src\datamapper\abstracts;

use Mselyatin\Project15\src\common\interfaces\IdentityMapInterface;
use Mselyatin\Project15\src\common\interfaces\StorageInterface;
use Mselyatin\Project15\src\common\storages\DbStorage;
use Mselyatin\Project15\src\datamapper\interfaces\DataMapperInterface;

/**
 * Class DataMapperAbstract
 * @package Mselyatin\Project15\src\datamapper\abstracts
 */
abstract class DataMapperAbstract implements DataMapperInterface
{
    /** @var DbStorage  */
    protected DbStorage $storage;

    /** @var IdentityMapInterface  */
    protected IdentityMapInterface $identityMap;

    /**
     * DataMapperAbstract constructor.
     * @param DbStorage $storage
     * @param IdentityMapInterface $identityMap
     */
    public function __construct(
        DbStorage $storage,
        IdentityMapInterface $identityMap
    ) {
        $this->storage = $storage;
        $this->identityMap = $identityMap;
    }
}