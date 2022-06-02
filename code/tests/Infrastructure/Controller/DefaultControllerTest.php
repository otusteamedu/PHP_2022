<?php

namespace App\Tests\Infractructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testUpdateStatusWrong(): void
    {
        $client = static::createClient();
        $client->request('GET', '/?card_number=5168745115682222&card_holder=Aleksey-Shevhenko&card_expiration=12/23&cvv=200&order_number=1111111111111&sum=10.1');
        $response = $client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
    }

   public function testUpdateStatusSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/?card_number=5168745115682222&card_holder=Aleksey-Shevhenko&card_expiration=12/23&cvv=200&order_number=1234567890&sum=50');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testException(): void
    {
        try {
            $client = static::createClient();
            $client->request('GET', '/');
        } catch (\TypeError $e) {
            $this->assertEquals(0, $e->getCode());
        }
    }
}