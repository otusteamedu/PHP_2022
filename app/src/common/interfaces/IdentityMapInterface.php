<?php

namespace Mselyatin\Project15\src\common\interfaces;

/**
 * Interface IdentityMapInterface
 * @package Mselyatin\Project15\src\common\interfaces
 */
interface IdentityMapInterface
{
    public static function getInstance();
    public function add(IdentityInterface $identity, $key);
    public function get($key);
}