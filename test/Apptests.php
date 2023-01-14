<?php

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

/**
 * Test app's restAPI
 */
class Apptests extends TestCase
{
    const API_URL = 'http://90.156.203.124:8005/';

    /**
     * @return void
     */
    public function testHello()
    {
        $result = file_get_contents(self::API_URL);
        $this->assertEquals($result, 'Otus HomeWork #11 (for lesson #13) - REDIS');
    }

    private $testCases = [
        [
            'action' => 'api/event/delete_all/',            // delete all
            'method' => 'POST',
            'data' => [
                "key" => "event"
            ],
            'result' => ['Storage cleared'],
        ],
        [
            'action' => 'api/event/add/',                   // add
            'method' => 'POST',
            'data' => [
                "key" => "event",
                "score" => 1000,
                "conditions" => "param1=1",
                "event_description" => "event1"
            ],
            'result' => 'Event added',
        ],
        [
            'action' => 'api/event/add/',                   // add
            'method' => 'POST',
            'data' => [
                "key" => "event",
                "score" => 2000,
                "conditions" => "param1=1,param2=2",
                "event_description" => "event2"
            ],
            'result' => 'Event added',
        ],
        [
            'action' => 'api/event/add/',                   // add
            'method' => 'POST',
            'data' => [
                "key" => "event",
                "score" => 3000,
                "conditions" => "param1=1,param2=2",
                "event_description" => "event3"
            ],
            'result' => 'Event added',
        ],
        [
            'action' => 'api/event/get_all/',               // get_all
            'method' => 'POST',
            'data' => [
                "key" => "event",
            ],
            'result' => [
                '{"conditions":"param1=1","event":"event1"}',
                '{"conditions":"param1=1,param2=2","event":"event2"}',
                '{"conditions":"param1=1,param2=2","event":"event3"}'
            ],
        ],
        [
            'action' => 'api/event/get/',                   // get single
            'method' => 'POST',
            'data' => [
                "key" => "event",
                "conditions" => "param1=1,param2=2"
            ],
            'result' => ['{"conditions":"param1=1,param2=2","event":"event3"}' => 3000],
        ],
        [
            'action' => 'api/event/delete/',               // delete single
            'method' => 'POST',
            'data' => [
                "key" => "event",
                "score" => 2000,
                "conditions" => "param=1,param2=2",
                "event_description" => "event2"
            ],
            'result' => "Event event2 deleted",
        ],
        [
            'action' => 'api/event/delete_all/',            // delete all
            'method' => 'POST',
            'data' => [
                "key" => "event",
            ],
            'result' => ["Storage cleared"],
        ],
        [
            'action' => 'api/event/get_all/',               // get_all (empty)
            'method' => 'POST',
            'data' => [
                "key" => "event",
            ],
            'result' => "[]",
        ],
    ];

    /**
     * @param string $action
     * @param array $data
     * @return mixed
     */
    protected function sendPostRequest(string $action, array $data)
    {
        $client = new Client();
        $result = $client->post(self::API_URL . $action, [
            'json' => $data
        ]);

        $resp = $result->getBody()->getContents();
        $json = json_decode($resp, true);

        return ($json ?: $resp);
    }

    /**
     * @return bool
     */
    private function testApi($data)
    {
        if (!is_array($data) || !count($data)) {
            return false;
        }

        switch ($data['method']) {
            case 'POST':
                $res = $this->sendPostRequest($data['action'], $data['data']);
                break;
            default:
                throw new \Exception("Unknown method: " . $data['method']);
        }

        echo PHP_EOL . "----------------------------------------------------------------------------" . PHP_EOL;

        echo $data['method'] . " request: " . self::API_URL . $data['action'] . PHP_EOL;

        echo "Request data: " . PHP_EOL;
        var_dump($data['data']);

        echo "Result: " . PHP_EOL;
        var_dump($res);

        $success = boolval($res == $data['result']);

        if (!$success) {
            echo "\033[31mTEST FAILED\033[0m" . PHP_EOL;
            echo "Excpected:" . var_export($data['result'], 1) . PHP_EOL;
            echo "Result:" . var_export($res, 1) . PHP_EOL;
        }

        $this->assertEquals($data['result'], $res);

        return $success;
    }

    /**
     * @param $args
     * @return int|void
     */
    public function testRun()
    {
        echo "BEGIN test" . PHP_EOL;

        foreach ($this->testCases as $testData) {
            $success = $this->testApi($testData);
            $this->assertEquals($success, true);
            if ($success) {
                echo "\033[32m- OK\033[0m" . PHP_EOL;
            } else {
                echo "\033[31m- FAIL\033[0m" . PHP_EOL;
            }
        }

        echo PHP_EOL . "FINISH test" . PHP_EOL;
    }
}