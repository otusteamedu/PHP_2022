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
        return $this->repository->setDocument($channel);
    }

    public function getChannel(string $index, string $id): ElasticModel
    {
        return $this->repository->getDocument($index, $id);
    }

    public function deleteChannel(string $index, string $id = ''): array
    {
        return $this->repository->delete($index, $id);
    }
}