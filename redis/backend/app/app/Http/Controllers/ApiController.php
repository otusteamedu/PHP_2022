<?php

namespace App\Http\Controllers;

use Predis;

class ApiController extends Controller
{
    public function root()
    {
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'otus-redis-redis',
            'port'   => 6379,
        ]);

        $client->set('foo', 'bar');

        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }
}
