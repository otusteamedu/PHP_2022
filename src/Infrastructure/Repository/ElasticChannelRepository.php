<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Channel;
use App\Infrastructure\ElasticSearch\ElasticSearch;
use Elastic\Elasticsearch\Exception\ClientResponseException;

class ElasticChannelRepository implements ChannelRepositoryInterface
{
    public function __construct(
        private readonly ChannelRepositoryInterface $service,
        private readonly ElasticSearch $search,
    ) {}


    public function getChannel(string $id): Channel
    {
        $channel = null;

        try {
            $query = $this->search->search([
                'index' => Channel::INDEX,
                'type' => Channel::TYPE,
                'body'  => [
                    'query' => [
                        'match' => [
                            'query' => $id
                        ]
                    ]
                ],
                'size' => 1,
            ]);

            $result = $query->asArray();

            if ($result && $result['hits']['hits']) {
                $channelData = $result['hits']['hits'][0];

                $channel = $this->parseChannel($channelData);
            }
        } catch (ClientResponseException $exception) {
            // nothing
        }

        if ($channel) {
            return $channel;
        }

        $channel = $this->service->getChannel($id);
        if (!$channel) {
            throw new \Exception('Channel not found');
        }

        $this->search->index([
            'index' => Channel::INDEX,
            'type' => Channel::TYPE,
            'id' => $channel->getId(),
            'body' => [
                'id' => $channel->getId(),
                'title' => $channel->getTitle(),
                'description' => $channel->getDescription(),
                'likes' => $channel->getLikes(),
                'dislikes' => $channel->getDislikes(),
            ]
        ]);

        return $channel;
    }


    public function getTop(int $count): array
    {
        $result = [];

        try {
            $query = $this->search->search([
                'index' => Channel::INDEX,
                'size' => 1000,
            ]);

            $queryResult = $query->asArray();

            if ($queryResult && $queryResult['hits']['hits']) {
                foreach ($queryResult['hits']['hits'] as $channelData) {
                    $result[] = $this->parseChannel($channelData);
                }
            }

            usort($result, fn (Channel $a, Channel $b) => ($a->getRating() < $b->getRating()) ? 1 : -1);
        } catch (ClientResponseException $exception) {
            // nothing
        }

        return array_slice($result, 0, $count);
    }


    private function parseChannel(array $data): Channel
    {
        $source = $data['_source'];

        return new Channel($data['_id'], $source['title'], $source['description'], $source['likes'], $source['dislikes']);
    }
}
