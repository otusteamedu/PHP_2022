<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 28.12.2022 23:54
 */

namespace Ppro\Hw15\Repositories;

interface RepositoryInterface
{
    public function findSession(int $id);
}