<?php

namespace Elastic\App\Service;

use Elastic\App\Model\Channel;
use Elastic\App\Model\ElasticModel;
use Elastic\App\Repository\ElasticRepository;

class ChannelService
{
    private ElasticRepository $repository;

    public function __construct(ElasticRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createChannel(Channel $channel): array
    {
        return $this->repository->set($channel);
    }

    public function getChannel(string $index, string $id): ElasticModel
    {
        return $this->repository->get($index, $id);
    }

    public function deleteChannel(string $index, string $id = ''): array
    {
        return $this->repository->delete($index, $id);
    }
}