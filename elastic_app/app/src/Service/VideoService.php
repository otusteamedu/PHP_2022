<?php

namespace Elastic\App\Service;

use Elastic\App\Model\ElasticModel;
use Elastic\App\Model\Video;
use Elastic\App\Repository\ElasticRepository;

class VideoService
{
    private ElasticRepository $repository;

    public function __construct(ElasticRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addVideo(Video $channel): array
    {
        return $this->repository->setDocument($channel);
    }

    public function getVideo(string $index, string $id): ElasticModel
    {
        return $this->repository->getDocument($index, $id);
    }

    public function deleteVideo(string $index, string $id = ''): array
    {
        return $this->repository->delete($index, $id);
    }
}