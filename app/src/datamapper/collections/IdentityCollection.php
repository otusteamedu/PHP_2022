<?php

namespace Mselyatin\Project15\src\datamapper\collections;

use Mselyatin\Project15\src\datamapper\interfaces\IdentityInterface;

/**
 * Class CarCollection
 * @package Mselyatin\Project15\src\datamapper\collections
 */
class IdentityCollection
{
    /** @var array  */
    private array $members = [];

    /**
     * @param IdentityInterface $identity
     * @param null $key
     * @return bool
     */
    public function addItem(IdentityInterface $identity, $key = null): bool
    {
        if ($key !== null) {
            if (isset($this->members[$key])) {
                return false;
            }

            $this->members[$key] = $identity;
        } else {
            $this->members[] = $identity;
        }

        return true;
    }

    /**
     * @param mixed $key
     */
    public function removeItem($key): bool
    {
        if (isset($this->members[$key])) {
            unset($this->members[$key]);
        }

        return true;
    }

    /**
     * @param $key
     * @return IdentityInterface|null
     */
    public function getItem($key): ?IdentityInterface
    {
        return $this->members[$key] ?? null;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return count($this->members);
    }

    /**
     * @param array $members
     * @return static
     */
    public static function create($members = []): self
    {
        $collection = new self();

        if ($members) {
            foreach ($members as $key => $value) {
                $collection->addItem($value, $key);
            }
        }

        return $collection;
    }
}