<?php
/**
 * Description of ArticlesQueueWorker.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Console\Commands\Geo;


use Carbon\Carbon;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class GeoIndex extends Command
{

    const INDEX_NAME = 'otus-orders';

    protected $signature = 'geo';

    public function handle(Client $elasticsearch)
    {
        $this->createIndexWithMapping($elasticsearch);
        $this->indexData($elasticsearch);
    }

    private function createIndexWithMapping(Client $elasticsearch): void
    {
        $this->createIndex($elasticsearch);
        $this->putMapping($elasticsearch);
    }

    private function createIndex(Client $elasticsearch): void
    {
        try {
            $elasticsearch->indices()->delete([
                'index' => self::INDEX_NAME,
            ]);
        } catch (\Exception $e) {

        }
        $elasticsearch->indices()->create([
            'index' => self::INDEX_NAME,
        ]);
    }

    private function putMapping(Client $elasticsearch): void
    {
        $elasticsearch->indices()->putMapping([
            'index' => self::INDEX_NAME,
            'body' => [
                'properties' => [
                    'time' => [
                        'type' => 'date',
                    ],
                    'userLocation' => [
                        'type' => 'geo_point',
                    ],
                    'fullPrice' => [
                        'type' => 'float',
                    ],
                    'company_id' => [
                        'type' => 'integer',
                    ],
                    'deliveryType' => [
                        'type' => 'integer',
                    ],
                ]
            ],
        ]);

    }

    private function indexData(Client $elasticsearch): void
    {
        $data = $this->getData();

        foreach ($data as $datum) {
            $this->indexItem($elasticsearch, $datum);
            $this->output->write('.');
        }
    }

    private function getData(): array
    {
        $data = file_get_contents(__DIR__ . '/data.json');
        return json_decode($data, true);
    }

    private function indexItem(Client $elasticsearch, array $datum): void
    {
        $datum['time'] = (int)(Carbon::createFromTimestamp($datum['time'])->subHour()->getTimestamp() . '000');
        $elasticsearch->index([
            'index' => self::INDEX_NAME,
            'id' => $datum['id'],
            'body' => $datum,
        ]);
    }

}
