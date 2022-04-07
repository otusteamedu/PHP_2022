<?php


use Elasticsearch\Client;


class ElasticsearchSearchRepository
{
    public function __construct(private Client $elasticsearch)
    {
    }

//    public function search()
//    {
//
//    }

    public function save(VideoDto $dto): void
    {
        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($dto), [
                'body' => $this->toSearchArray($dto),
            ]));
    }

    public function delete(VideoDto $dto): void
    {
        $this->elasticsearch->delete(
            $this->generateElasticSearchParams($dto)
        );
    }

    private function generateElasticSearchParams(VideoDto $dto): array
    {
        return [
            'index' => 'video_index',
            'type' => 'video_index',
            'id' => $dto->id,
        ];
    }

    private function toSearchArray(VideoDto $dto): array
    {
        return [
            'video_title' => $dto->videoTitle,
            'video_seconds' => $dto->videoSeconds,
            'description' => $dto->description,
            'like' => $dto->like,
            'dislike' => $dto->dislike,
        ];
    }
}
