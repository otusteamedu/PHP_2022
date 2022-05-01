<?php


namespace App\Repositories;


use App\Dtos\VideoDto;
use Elasticsearch\Client;

class VideoElasticsearchSearchRepository
{
    public const INDEX = 'video_index';

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function get(array $params): array
    {
        return $this->elasticsearch->get($params);
    }

    public function search(array $params): array
    {
        return $this->elasticsearch->search($params);
    }

    public function save(VideoDto $dto): void
    {
        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($dto->id), [
                'body' => $this->toSearchArray($dto),
            ]));
    }

    public function delete(string $id): void
    {
        $this->elasticsearch->delete(
            $this->generateElasticSearchParams($id)
        );
    }

    public function createIndex(): array
    {
        $params = [
            'index' => self::INDEX,
            'body'  => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'video_chanel' => [
                            'type' => 'keyword'
                        ],
                        'video_title' => [
                            'type' => 'keyword'
                        ],
                        'description' => [
                            'type' => 'text'
                        ],
                        'video_seconds' => [
                            'type' => 'integer'
                        ],
                        'like' => [
                            'type' => 'integer'
                        ],
                        'dislike' => [
                            'type' => 'integer'
                        ]
                    ]
                ],
            ]
        ];

        return $this->elasticsearch->indices()->create($params);
    }

    private function generateElasticSearchParams(string $id): array
    {
        return [
            'index' => self::INDEX,
            'id' => $id,
        ];
    }

    private function toSearchArray(VideoDto $dto): array
    {
        return [
            'video_title' => $dto->videoTitle,
            'video_chanel' => $dto->videoChanel,
            'video_seconds' => $dto->videoSeconds,
            'description' => $dto->description,
            'like' => $dto->like,
            'dislike' => $dto->dislike,
        ];
    }
}
