<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Channel;

interface ChannelRepositoryInterface
{

    public function getChannel(string $id): ?Channel;

}
