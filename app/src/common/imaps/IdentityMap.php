<?php

namespace Mselyatin\Project15\src\common\imaps;

use Mselyatin\Project15\src\common\interfaces\IdentityInterface;
use Mselyatin\Project15\src\datamapper\collections\IdentityCollection;
use Mselyatin\Project15\src\common\interfaces\IdentityMapInterface;

/**
 * Class IdentityMap
 * @package Mselyatin\Project15\src\common\imaps
 */
class IdentityMap implements IdentityMapInterface
{
    /**
     * @var IdentityCollection
     */
    private static IdentityCollection $collection;

    /** @var ?IdentityMap $this  */
    private static ?self $instance = null;

    private function __construct()
    {
        static::$collection = IdentityCollection::create();
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        return static::$instance ?? new self();
    }

    /**
     * @param $key
     * @param IdentityInterface $identity
     */
    public function add(IdentityInterface $identity, $key): void
    {
        static::$collection->addItem($identity, $key);
    }

    /**
     * @param $key
     * @return IdentityInterface|null
     */
    public function get($key): ?IdentityInterface
    {
        return static::$collection->getItem($key);
    }
}