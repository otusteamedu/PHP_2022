<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 28.12.2022 23:54
 */

namespace Ppro\Hw13\Repositories;

use Ppro\Hw13\Data\EventDTO;
use Ppro\Hw13\Data\ParamsDTO;

interface RepositoryInterface
{
    public function addEvent(EventDTO $event): void;

    public function findEvent(ParamsDTO $params);

    public function removeEvents();
}