<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Application\Request;

use Nikcrazy37\Hw20\Domain\Request;
use Nikcrazy37\Hw20\Domain\Status;
use Nikcrazy37\Hw20\Infrastructure\Repository\Redis;

class ProcessRequest
{
    private Redis $rep;

    public function __construct(Redis $rep)
    {
        $this->rep = $rep;
    }

    public function createRequest(string $uid): void
    {
        $request = new Request(
            $uid,
            Status::Pending
        );

        $this->rep->add($request);
    }

    public function changeStatus(string $uid)
    {
        sleep(10);

        $request = new Request(
            $uid,
            Status::Completed
        );

        $this->rep->edit($request);
    }

    public function checkRequest(string $uid): string
    {
        return $this->rep->get($uid);
    }
}