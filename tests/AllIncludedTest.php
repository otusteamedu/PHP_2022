<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllIncludedTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $client->request('POST', '/event', [
            [
                'priority' => 1000,
                'conditions' => [
                    'param1' => 1,
                ],
                'event' => 'event1',
            ],
            [
                'priority' => 2000,
                'conditions' => [
                    'param1' => 2,
                    'param2' => 2,
                ],
                'event' => 'event2',
            ],
            [
                'priority' => 3000,
                'conditions' => [
                    'param1' => 1,
                    'param2' => 2,
                ],
                'event' => 'event3',
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $client->request('GET', '/event', [
            'params' => [
                'param1' => 1,
                'param2' => 2,
            ],
        ]);

        $response = $client->getResponse();


        $this->assertJsonStringEqualsJsonString(
            '{"event":"event3","priority":3000,"conditions":{"param2":"2","param1":"1"}}',
            $response->getContent()
        );
    }
}
