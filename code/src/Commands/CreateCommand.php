<?php

namespace Svatel\Code\Commands;

use Elastic\Elasticsearch\Client;

class CreateCommand
{
    public function __construct(
        private Client $client,
        private string $indexName,
        private string $pathIndex,
        private ?string $pathMapping = null
    ) {
    }

    public function create(): bool
    {
        try {
            if (!is_null($this->pathMapping)) {
                $this->createMapping();
            }
            $file = fopen($this->pathIndex, 'r');
            $count = 0;
            $params = ['body' => []];
            while (!feof($file)) {
                $count = $count + 1;
                $line = fgets($file);
                $params['body'][] = $this->createParams($line);
                if ($count % 2 == 0) {
                    $responses = $this->client->bulk($params);
                    $params = ['body' => []];
                    unset($responses);
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function createMapping(): void
    {
        $params['index'] = $this->indexName;
        $params['body'] = json_decode(file_get_contents($this->pathMapping), true);
        $this->client->indices()->delete(['index' => $this->indexName]);
        $this->client->indices()->create($params);
    }

    private function createParams(string $line): array
    {
        $res = json_decode($line, true);
        if (isset($res['create'])) {
            return [
                'index' => [
                    '_index' => $res['create']['_index'],
                    '_id' => $res['create']['_id']
                ]
            ];
        } else {
            return array_map(
                function (string $key) use ($res) {
                    return "{$key} => {$res[$key]}";
                }, array_keys($res)
            );
        }
    }
}
